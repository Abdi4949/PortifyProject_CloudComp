<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Method ini yang HILANG sebelumnya.
     * Fungsinya: Simpan ke DB -> Minta Token ke Midtrans -> Balikin Token
     */
    public function createTransaction($user, $planSlug, $amount)
    {
        // 1. Buat Order ID Unik (Pakai Helper dari Model Transaction kamu)
        // Format: PORT-{TIMESTAMP}-{USER_ID}
        $orderId = Transaction::generateOrderId($user->id);

        // 2. Siapkan Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount, // Pastikan integer
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $planSlug,
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => strtoupper(str_replace('_', ' ', $planSlug)),
                ]
            ]
        ];

        try {
            // 3. Request Snap Token ke Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 4. Simpan ke Database (PENTING: Sebelum return token)
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'order_id' => $orderId,
                'subscription_plan' => $planSlug,
                'amount' => $amount,
                'total_amount' => $amount,
                'status' => 'pending',
                'midtrans_response' => json_encode($params),
            ]);

            // 5. Kembalikan data sukses
            return [
                'success' => true,
                'snap_token' => $snapToken,
                'transaction' => $transaction
            ];

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal koneksi ke Midtrans: ' . $e->getMessage()
            ];
        }
    }
}