<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        My Portfolios 📂
                    </h2>
                    <p class="text-gray-500 mt-1">Manage and edit your creative works</p>
                </div>
                
                <a href="{{ route('templates.index') }}" class="group bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-purple-300 hover:scale-105 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New
                </a>
            </div>

            @if($portfolios->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($portfolios as $portfolio)
                    <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group relative overflow-hidden">
                        
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 opacity-50 blur-xl group-hover:scale-150 transition-transform duration-500"></div>

                        <div class="flex justify-between items-start mb-4 relative z-10">
                            <div class="bg-gray-100 p-3 rounded-2xl group-hover:bg-purple-50 transition-colors">
                                <svg class="w-8 h-8 text-gray-500 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                {{ $portfolio->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $portfolio->status }}
                            </span>
                        </div>

                        <div class="flex-1 relative z-10">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1" title="{{ $portfolio->title }}">
                                {{ $portfolio->title }}
                            </h3>
                            
                            <div class="text-sm text-gray-500 space-y-1 mb-6">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                                    {{ optional($portfolio->template)->name ?? 'Unknown Template' }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Updated {{ $portfolio->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-4 relative z-10">
                            <a href="{{ route('portfolios.edit', $portfolio->id) }}" class="flex justify-center items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 text-gray-700 font-semibold hover:bg-gray-100 transition-colors border border-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('portfolios.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2 rounded-xl bg-white text-red-500 font-semibold hover:bg-red-50 hover:text-red-600 transition-colors border border-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl shadow-lg border border-gray-100">
                    <div class="bg-purple-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Portfolios Yet</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">It looks a bit empty here. Choose a template and start building your personal brand today!</p>
                    <a href="{{ route('templates.index') }}" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-xl">
                        Browse Templates
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>