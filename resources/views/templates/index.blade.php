<x-app-layout>
    <div class="min-h-screen bg-[#0f172a] text-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="relative bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 rounded-3xl p-10 mb-12 shadow-2xl shadow-purple-900/20 overflow-hidden border border-white/10 text-center">
                <div class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 rounded-full bg-blue-500 opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-72 h-72 rounded-full bg-pink-500 opacity-20 blur-3xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                        Choose Your Perfect Canvas 🎨
                    </h2>
                    <p class="text-purple-100 text-lg max-w-2xl mx-auto opacity-90 mb-8">
                        Start with a professionally designed template. Customize it to match your style and launch your portfolio in minutes.
                    </p>

                    <div class="flex flex-wrap justify-center items-center gap-6 mt-8">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 px-6 py-2 rounded-full text-white text-sm font-semibold shadow-lg">
                            ✨ {{ $templates->count() ?? 0 }} Templates Available
                        </div>
                        
                        @if(Auth::user()->account_type !== 'pro')
                        <a href="{{ route('upgrade') }}" class="group bg-white text-purple-700 px-6 py-2 rounded-full text-sm font-bold hover:bg-gray-100 transition shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Unlock Premium
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($templates as $template)
                    @php
                        // Logic check pro vs free
                        // Prioritaskan data dari database jika ada key 'is_premium', jika tidak fallback ke ID > 5
                        $isPro = isset($template['is_premium']) ? $template['is_premium'] : ($template['id'] > 5);
                        $userCanAccess = !$isPro || (Auth::user()->account_type === 'pro');
                    @endphp

                    <div class="group relative bg-slate-800 rounded-3xl overflow-hidden border transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-900/20 flex flex-col h-full
                        {{ $isPro ? 'border-slate-600 hover:border-purple-500/50' : 'border-slate-700 hover:border-emerald-500/50' }}">
                        
                        <div class="absolute top-4 right-4 z-20">
                            @if($isPro)
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1 border border-white/20">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    PRO
                                </div>
                            @else
                                <div class="bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg border border-white/20">
                                    FREE
                                </div>
                            @endif
                        </div>

                        <div class="relative h-56 bg-slate-900 overflow-hidden group-hover:opacity-100 transition-opacity">
                            
                            <div class="w-[400%] h-[400%] origin-top-left transform scale-[0.25]">
                                <iframe 
                                    src="{{ route('templates.show', $template['id']) }}" 
                                    class="w-full h-full border-0 pointer-events-none select-none bg-white"
                                    scrolling="no"
                                    loading="lazy"
                                    tabindex="-1">
                                </iframe>
                            </div>

                            <div class="absolute inset-0 bg-transparent z-10"></div>

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-60 z-10 pointer-events-none"></div>
                            
                            <div class="absolute inset-0 bg-slate-900/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-20 backdrop-blur-sm">
                                <a href="{{ route('templates.show', $template['id']) }}" target="_blank" class="bg-white text-slate-900 px-6 py-2 rounded-full text-sm font-bold shadow-xl hover:scale-105 transition-transform flex items-center gap-2">
                                    <span>👁️ Preview Full Screen</span>
                                </a>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-purple-400 transition-colors">{{ $template['name'] }}</h3>
                            <p class="text-slate-400 text-sm mb-6 flex-1 line-clamp-2">
                                {{ $template['description'] ?? 'A professional template designed to showcase your work and skills effectively.' }}
                            </p>

                            <div class="mb-6 space-y-2 border-t border-slate-700 pt-4">
                                <div class="flex items-center text-xs text-slate-300">
                                    <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Responsive Layout
                                </div>
                                <div class="flex items-center text-xs text-slate-300">
                                    <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    PDF Ready
                                </div>
                                <div class="flex items-center text-xs text-slate-300">
                                    <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                                    {{ $template['layout'] ?? 'Standard Layout' }}
                                </div>
                            </div>

                            @if($userCanAccess)
                                <form action="{{ route('templates.select', $template['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold shadow-lg transform active:scale-95 transition-all flex justify-center items-center gap-2
                                        {{ $isPro 
                                            ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white hover:shadow-purple-500/30 hover:to-indigo-500' 
                                            : 'bg-white text-slate-900 hover:bg-slate-100' }}">
                                        <span>Use This Template</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('upgrade') }}" class="w-full py-3 px-4 rounded-xl font-bold border border-purple-500/50 text-purple-300 bg-purple-500/10 hover:bg-purple-500/20 hover:text-white transition-all flex justify-center items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Upgrade to Unlock
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($templates->count() == 0)
                <div class="text-center py-20 bg-slate-800 rounded-3xl shadow-sm border border-slate-700 mt-10">
                    <div class="bg-slate-700 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">No Templates Found</h3>
                    <p class="text-slate-400 mt-2">Check back later for new designs!</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>