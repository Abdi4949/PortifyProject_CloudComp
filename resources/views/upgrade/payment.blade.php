<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    
                    <h3 class="text-2xl font-bold mb-4">Confirm Your Subscription</h3>
                    
                    <div class="bg-gray-50 p-6 rounded-xl max-w-md mx-auto mb-6 border border-gray-200">
                        <p class="text-gray-600 mb-2">Order ID: <span class="font-mono font-bold text-black">{{ $transaction->order_id }}</span></p>
                        <p class="text-gray-600 mb-2">Plan: <span class="font-bold text-purple-600">{{ strtoupper(str_replace('_', ' ', $transaction->subscription_plan)) }}</span></p>
                        <div class="text-3xl font-extrabold text-gray-900 mt-4">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <button id="pay-button" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                        Pay Now via Midtrans
                    </button>

                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    
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
                    alert('You closed the popup without finishing the payment');
                }
            });
        };
    </script>
</x-app-layout>