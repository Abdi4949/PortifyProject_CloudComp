<x-app-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

    <div class="py-12 bg-gray-900 min-h-screen relative overflow-hidden">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gray-800 border border-gray-700 shadow-2xl sm:rounded-2xl overflow-hidden">
                
                <div class="bg-gray-800/50 p-6 border-b border-gray-700 text-center">
                    <div class="mx-auto w-16 h-16 bg-purple-900/50 rounded-full flex items-center justify-center mb-4 border border-purple-500/30">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Confirm Subscription</h3>
                    <p class="text-gray-400">Please review your order details before paying.</p>
                </div>

                <div class="p-8">
                    
                    <div class="bg-gray-900/50 p-6 rounded-xl border border-gray-700 border-dashed max-w-md mx-auto mb-8 relative">
                        <div class="absolute -left-3 top-1/2 w-6 h-6 bg-gray-800 rounded-full"></div>
                        <div class="absolute -right-3 top-1/2 w-6 h-6 bg-gray-800 rounded-full"></div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-gray-700 pb-4">
                                <span class="text-gray-400">Order ID</span>
                                <span class="font-mono font-bold text-gray-200 tracking-wider">{{ $transaction->order_id }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center border-b border-gray-700 pb-4">
                                <span class="text-gray-400">Plan</span>
                                <span class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">
                                    {{ strtoupper(str_replace('_', ' ', $transaction->subscription_plan)) }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center pt-2">
                                <span class="text-gray-400">Total Amount</span>
                                <span class="text-3xl font-extrabold text-white">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button id="pay-button" class="w-full max-w-md mx-auto bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-purple-900/40 transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Secure Pay via Midtrans
                        </button>
                        <p class="text-xs text-gray-500 mt-4 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            Encrypted & Secure Transaction
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            // SnapToken dari Controller
            snap.pay('{{ $snapToken }}', {
                // Callback jika sukses
                onSuccess: function(result){
                    window.location.href = "{{ route('upgrade.finish') }}";
                },
                // Callback jika pending (User tutup popup tapi blm bayar)
                onPending: function(result){
                    window.location.href = "{{ route('upgrade.pending') }}";
                },
                // Callback jika error/gagal
                onError: function(result){
                    window.location.href = "{{ route('upgrade.error') }}";
                },
                // Callback jika ditutup manual
                onClose: function(){
                    // Opsional: Bisa dikosongkan atau beri alert
                    console.log('Popup closed');
                }
            });
        };
    </script>
</x-app-layout>