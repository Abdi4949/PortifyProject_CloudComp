<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen relative overflow-hidden flex items-center justify-center">
        
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-pink-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-md w-full mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gray-800 border border-gray-700 shadow-2xl rounded-2xl p-8 text-center transform transition-all hover:scale-[1.01]">
                
                <div class="mb-8 relative inline-block">
                    <div class="absolute inset-0 bg-green-500/30 rounded-full animate-ping"></div>
                    <div class="relative bg-green-900/50 rounded-full w-24 h-24 flex items-center justify-center border-2 border-green-500 mx-auto">
                        <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl font-extrabold text-white mb-2">Payment Successful!</h2>
                <div class="inline-block px-3 py-1 bg-purple-900/50 border border-purple-500/30 rounded-full mb-4">
                    <span class="text-xs font-bold text-purple-300 uppercase tracking-wider">Pro Account Unlocked</span>
                </div>
                
                <p class="text-gray-400 mb-8 leading-relaxed">
                    Thank you for upgrading. You now have unlimited access to all premium features and templates.
                </p>
                
                <a href="{{ route('dashboard') }}" class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-purple-900/40 transition-all transform hover:-translate-y-1">
                    Go to Dashboard
                </a>

            </div>
        </div>
    </div>
</x-app-layout>