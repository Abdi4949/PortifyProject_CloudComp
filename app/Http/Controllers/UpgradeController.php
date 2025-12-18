<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class UpgradeController extends Controller
{
    protected $midtransService;
    
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isPro()) {
            return redirect()
                ->route('dashboard')
                ->with('info', 'You are already a Pro member!');
        }
        
        $plans = [
            [
                'name' => 'Pro Monthly',
                'slug' => 'pro_monthly',
                'price' => 35000,
                'period' => 'month',
                'features' => [
                    'Unlimited PDF exports',
                    'Access to all premium templates',
                    'Priority support',
                    'Custom branding options',
                    'Advanced analytics',
                ]
            ],
            [
                'name' => 'Pro Yearly',
                'slug' => 'pro_yearly',
                'price' => 350000, // <-- PERBAIKAN HARGA
                'period' => 'year',
                'savings' => '2 months free!',
                'features' => [
                    'Everything in Monthly',
                    'Save 17% annually',
                    'Early access to new features',
                    'Exclusive templates',
                    'Premium customer support',
                ]
            ],
        ];
        
        return view('upgrade.index', compact('plans', 'user'));
    }
    
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan' => 'required|in:pro_monthly,pro_yearly'
        ]);
        
        $user = auth()->user();
        
        if ($user->isPro()) {
            return back()->with('error', 'You are already a Pro member!');
        }
        
        // PERBAIKAN: Set amount yang benar
        $amount = match($validated['plan']) {
            'pro_monthly' => 35000,
            'pro_yearly' => 350000, // <-- PERBAIKAN DI SINI (Sebelumnya 0000)
        };
        
        // Pastikan MidtransService membuat record di tabel `transactions`
        // sebelum me-return snap token!
        $result = $this->midtransService->createTransaction(
            $user,
            $validated['plan'],
            $amount
        );
        
        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }
        
        return view('upgrade.payment', [
            'snapToken' => $result['snap_token'],
            'transaction' => $result['transaction'],
            'clientKey' => config('midtrans.client_key')
        ]);
    }
    
    public function paymentFinish(Request $request)
    {
        return view('upgrade.finish');
    }
    
    public function paymentError(Request $request)
    {
        return view('upgrade.error');
    }
    
    public function paymentPending(Request $request)
    {
        return view('upgrade.pending');
    }
}