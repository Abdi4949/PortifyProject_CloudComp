<x-app-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Unlock Your Full Potential ✨
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Upgrade to Pro and get unlimited access to all premium features
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-12">
                @foreach($plans as $plan)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden {{ $plan['slug'] === 'pro_yearly' ? 'border-4 border-purple-500 relative' : 'border border-gray-200' }}">
                    
                    @if($plan['slug'] === 'pro_yearly')
                    <div class="absolute top-0 right-0 bg-purple-500 text-white px-4 py-1 text-sm font-bold rounded-bl-lg">
                        BEST VALUE
                    </div>
                    @endif

                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                        <div class="flex items-baseline mb-6">
                            <span class="text-5xl font-extrabold text-gray-900">Rp {{ number_format($plan['price'], 0, ',', '.') }}</span>
                            <span class="text-xl text-gray-600 ml-2">/ {{ $plan['period'] }}</span>
                        </div>

                        @if(isset($plan['savings']))
                        <div class="bg-green-50 border border-green-200 rounded-lg px-3 py-2 mb-6">
                            <p class="text-green-800 font-semibold text-sm">💰 {{ $plan['savings'] }}</p>
                        </div>
                        @endif

                        <ul class="space-y-4 mb-8">
                            @foreach($plan['features'] as $feature)
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>

                        <form action="{{ route('upgrade.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $plan['slug'] }}">
                            
                            <button type="submit" 
                                class="w-full py-4 px-6 rounded-lg font-bold text-lg transition-all
                                    {{ $plan['slug'] === 'pro_yearly' 
                                        ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:from-purple-700 hover:to-pink-700 shadow-lg hover:shadow-xl' 
                                        : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }}">
                                Choose {{ $plan['name'] }}
                            </button>
                        </form>

                    </div>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Feature Comparison</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-4 px-4 font-semibold text-gray-900">Feature</th>
                                <th class="text-center py-4 px-4 font-semibold text-gray-900">Free</th>
                                <th class="text-center py-4 px-4 font-semibold text-purple-600">Pro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-4 px-4">PDF Exports</td>
                                <td class="text-center py-4 px-4">3 / week</td>
                                <td class="text-center py-4 px-4 font-bold text-purple-600">Unlimited ✨</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-4">Free Templates</td>
                                <td class="text-center py-4 px-4">✅</td>
                                <td class="text-center py-4 px-4">✅</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-4">Premium Templates</td>
                                <td class="text-center py-4 px-4">❌</td>
                                <td class="text-center py-4 px-4 font-bold text-purple-600">✅</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-4">Custom Branding</td>
                                <td class="text-center py-4 px-4">❌</td>
                                <td class="text-center py-4 px-4 font-bold text-purple-600">✅</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-4">Priority Support</td>
                                <td class="text-center py-4 px-4">❌</td>
                                <td class="text-center py-4 px-4 font-bold text-purple-600">✅</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-4">Analytics Dashboard</td>
                                <td class="text-center py-4 px-4">Basic</td>
                                <td class="text-center py-4 px-4 font-bold text-purple-600">Advanced</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>