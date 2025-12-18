<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="text-yellow-500 mb-4 flex justify-center">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Pending</h2>
                <p class="text-gray-600 mb-6">Please complete your payment to activate Pro features.</p>
                
                <a href="{{ route('upgrade') }}" class="text-blue-600 hover:underline">
                    Try Again
                </a>
            </div>
        </div>
    </div>
</x-app-layout>