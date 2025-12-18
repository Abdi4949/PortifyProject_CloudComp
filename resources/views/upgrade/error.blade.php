<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="text-red-500 mb-4 flex justify-center">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Failed</h2>
                <p class="text-gray-600 mb-6">Something went wrong. Please try again later.</p>
                
                <a href="{{ route('upgrade') }}" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                    Back to Upgrade
                </a>
            </div>
        </div>
    </div>
</x-app-layout>