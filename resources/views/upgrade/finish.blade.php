<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="text-green-500 mb-4 flex justify-center">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h2>
                <p class="text-gray-600 mb-6">Thank you for upgrading to Pro. Your account features have been unlocked.</p>
                
                <a href="{{ route('dashboard') }}" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>