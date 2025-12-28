<x-app-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="py-12 bg-gray-900 min-h-screen relative overflow-hidden">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-white">
                    Unlock Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">Full Potential</span> ✨
                </h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Upgrade to Pro and get unlimited access to all premium features.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-20">
                @foreach($plans as $plan)
                <div class="relative rounded-2xl transition-all duration-300 hover:-translate-y-2
                    {{ $plan['slug'] === 'pro_yearly' 
                        ? 'bg-gray-800 border-2 border-purple-500 shadow-[0_0_30px_rgba(168,85,247,0.3)]' 
                        : 'bg-gray-800/50 border border-gray-700 hover:border-gray-600' }}">
                    
                    @if($plan['slug'] === 'pro_yearly')
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-1 text-xs font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-lg shadow-lg">
                        Best Value
                    </div>
                    @endif

                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $plan['name'] }}</h3>
                        
                        <div class="flex items-baseline mb-6">
                            <span class="text-5xl font-extrabold text-white">Rp {{ number_format($plan['price'], 0, ',', '.') }}</span>
                            <span class="text-lg text-gray-400 ml-2">/ {{ $plan['period'] }}</span>
                        </div>

                        @if(isset($plan['savings']))
                        <div class="inline-block bg-purple-900/30 border border-purple-500/30 rounded-full px-4 py-1.5 mb-8">
                            <p class="text-purple-300 font-semibold text-sm">💰 {{ $plan['savings'] }}</p>
                        </div>
                        @else
                        <div class="h-[46px] mb-6"></div> 
                        @endif

                        <ul class="space-y-4 mb-10">
                            @foreach($plan['features'] as $feature)
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-purple-900/50 flex items-center justify-center border border-purple-500/30 mr-3">
                                    <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>

                        <form action="{{ route('upgrade.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $plan['slug'] }}">
                            
                            <button type="submit" 
                                class="w-full py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 transform hover:scale-[1.02]
                                    {{ $plan['slug'] === 'pro_yearly' 
                                        ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:shadow-lg hover:shadow-purple-500/40 border border-transparent' 
                                        : 'bg-gray-700 text-white hover:bg-gray-600 border border-gray-600' }}">
                                Choose {{ $plan['name'] }}
                            </button>
                        </form>

                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-gray-800/80 backdrop-blur-md rounded-2xl shadow-xl border border-gray-700 overflow-hidden max-w-5xl mx-auto">
                <div class="p-8 border-b border-gray-700">
                    <h2 class="text-2xl font-bold text-white text-center">Compare Plans</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-900/50">
                                <th class="text-left py-5 px-6 font-semibold text-gray-300">Feature</th>
                                <th class="text-center py-5 px-6 font-semibold text-gray-300">Free</th>
                                <th class="text-center py-5 px-6 font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500 text-lg">Pro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <tr class="hover:bg-gray-700/30 transition">
                                <td class="py-4 px-6 text-gray-300">PDF Exports</td>
                                <td class="text-center py-4 px-6 text-gray-400">3 / week</td>
                                <td class="text-center py-4 px-6 font-bold text-white flex justify-center items-center gap-2">
                                    Unlimited <span class="text-yellow-400">✨</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-700/30 transition">
                                <td class="py-4 px-6 text-gray-300">Free Templates</td>
                                <td class="text-center py-4 px-6 text-gray-400">
                                    <svg class="w-5 h-5 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </td>
                                <td class="text-center py-4 px-6 text-white">
                                    <svg class="w-5 h-5 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-700/30 transition">
                                <td class="py-4 px-6 text-gray-300">Premium Templates</td>
                                <td class="text-center py-4 px-6 text-gray-500">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </td>
                                <td class="text-center py-4 px-6 text-white">
                                    <svg class="w-5 h-5 mx-auto text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-700/30 transition">
                                <td class="py-4 px-6 text-gray-300">Custom Branding</td>
                                <td class="text-center py-4 px-6 text-gray-500">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </td>
                                <td class="text-center py-4 px-6 text-white">
                                    <svg class="w-5 h-5 mx-auto text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-700/30 transition">
                                <td class="py-4 px-6 text-gray-300">Priority Support</td>
                                <td class="text-center py-4 px-6 text-gray-500">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </td>
                                <td class="text-center py-4 px-6 text-white">
                                    <svg class="w-5 h-5 mx-auto text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6 text-gray-300">Analytics Dashboard</td>
                                <td class="text-center py-4 px-6 text-gray-400">Basic</td>
                                <td class="text-center py-4 px-6 font-bold text-purple-400">Advanced</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>