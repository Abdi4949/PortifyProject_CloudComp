<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans dipanggil saat Controller diinisialisasi
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function handle(Request $request)
    {
        Log::info('Incoming Midtrans Notification', $request->all());

        try {
            // 1. Ambil Notifikasi dari Midtrans
            $notification = new Notification();

            $orderId = $notification->order_id;
            $status = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;

            // 2. Cari Transaksi di Database
            $transaction = Transaction::where('order_id', $orderId)->first();

            if (!$transaction) {
                Log::error("Transaction not found for Order ID: $orderId");
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // 3. Update Status Transaksi Berdasarkan Response Midtrans
            if ($status == 'capture') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'pending';
                } else {
                    $transaction->status = 'success';
                }
            } elseif ($status == 'settlement') {
                $transaction->status = 'success';
            } elseif ($status == 'pending') {
                $transaction->status = 'pending';
            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                $transaction->status = 'failed';
            }

            // Simpan perubahan status transaksi & tipe pembayaran
            $transaction->payment_type = $type;
            $transaction->save();

            // 4. UPDATE USER JADI PRO (Jika status success)
            if ($transaction->status === 'success') {
                $user = User::find($transaction->user_id);
                
                if ($user) {
                    $user->update(['account_type' => 'pro']);
                    Log::info("User ID {$user->id} upgraded to PRO via Order ID: $orderId");
                } else {
                    Log::error("User not found for Transaction ID: {$transaction->id}");
                }
            }

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            Log::error("Midtrans Callback Error: " . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}