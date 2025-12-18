<x-app-layout>
    <div class="py-12 bg-[#0f172a] min-h-screen text-slate-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="relative bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 rounded-3xl p-8 mb-10 shadow-2xl shadow-purple-900/20 overflow-hidden border border-white/10">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-blue-500 opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-pink-500 opacity-20 blur-3xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center text-white">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">
                            Welcome back, {{ Auth::user()->name }}! 🚀
                        </h1>
                        <p class="text-purple-100 text-lg font-light opacity-90">
                            Ready to craft your next digital masterpiece?
                        </p>
                    </div>
                    
                    <div class="mt-8 md:mt-0 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center shadow-lg">
                        <div class="bg-gradient-to-br from-white to-gray-200 text-purple-700 p-2.5 rounded-lg mr-4 shadow-sm">
                            @if(Auth::user()->account_type == 'pro')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] text-purple-200 uppercase font-bold tracking-wider mb-0.5">Current Plan</p>
                            <p class="font-bold text-xl leading-none">{{ ucfirst(Auth::user()->account_type ?? 'Free Member') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 flex items-center hover:bg-slate-800 transition-colors duration-300">
                    <div class="bg-blue-500/10 text-blue-400 p-4 rounded-xl mr-5 border border-blue-500/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase tracking-wide">Total Portfolios</p>
                        <h3 class="text-3xl font-bold text-white mt-1">
                            {{ Auth::user()->portfolios()->count() ?? 0 }}
                        </h3> 
                    </div>
                </div>

                <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 flex items-center hover:bg-slate-800 transition-colors duration-300">
                    <div class="bg-emerald-500/10 text-emerald-400 p-4 rounded-xl mr-5 border border-emerald-500/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm font-medium uppercase tracking-wide">Weekly Exports</p>
                        <h3 class="text-2xl font-bold text-white mt-1">
                            @if(Auth::user()->account_type == 'pro')
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 font-bold text-xl">Unlimited ✨</span>
                            @else
                                <span class="text-white">{{ Auth::user()->weekly_exports_count ?? 0 }}</span> <span class="text-sm text-slate-500 font-normal">/ 3 Used</span>
                            @endif
                        </h3>
                    </div>
                </div>

                <a href="{{ route('upgrade') }}" class="group relative bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-dashed border-purple-500/30 flex items-center justify-between cursor-pointer hover:border-purple-500 hover:bg-slate-800 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="flex items-center relative z-10">
                        <div class="bg-purple-500/10 text-purple-400 p-4 rounded-xl mr-5 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-lg group-hover:text-purple-300 transition-colors">Upgrade to Pro</p>
                            <p class="text-slate-500 text-xs mt-0.5">Unlock premium templates</p>
                        </div>
                    </div>
                    <div class="bg-slate-700/50 rounded-full p-2 group-hover:bg-purple-500/20 transition-colors relative z-10">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-xl font-bold text-white flex items-center mb-4">
                        <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
                        Quick Actions
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <a href="{{ route('templates.index') }}" class="relative group bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-900/10">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-transparent opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity"></div>
                            
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 text-white shadow-lg shadow-purple-900/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h4 class="font-bold text-white text-xl mb-2 relative z-10">Create New Portfolio</h4>
                            <p class="text-slate-400 text-sm relative z-10 leading-relaxed">Choose from our collection of stunning, professional templates.</p>
                        </a>

                        <a href="{{ route('portfolios.index') }}" class="relative group bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-900/10">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity"></div>

                            <div class="w-16 h-16 bg-slate-700 border border-slate-600 rounded-2xl flex items-center justify-center mb-6 text-blue-400 group-hover:bg-blue-600 group-hover:text-white group-hover:border-transparent transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h4 class="font-bold text-white text-xl mb-2 relative z-10">My Portfolios</h4>
                            <p class="text-slate-400 text-sm relative z-10 leading-relaxed">View, edit, or download your existing portfolio projects.</p>
                        </a>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-3xl border border-slate-700 p-6 h-fit shadow-lg shadow-black/20">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center text-xl font-bold text-white border-2 border-slate-500 mr-4">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-white truncate">{{ Auth::user()->name }}</h4>
                            <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-700/50 my-5"></div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Member Since</span>
                            <span class="font-semibold text-slate-300">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Next Reset</span>
                            <span class="font-semibold text-slate-300">
                                {{ \Carbon\Carbon::now()->endOfWeek()->format('M d') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center py-2.5 px-4 border border-slate-600 rounded-xl text-slate-300 font-medium hover:bg-slate-700 hover:text-white hover:border-slate-500 transition-all duration-200">
                            Manage Profile Settings
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>