<x-app-layout>
    <div class="min-h-screen bg-[#0f172a] flex flex-col justify-center py-12 sm:px-6 lg:px-8 text-slate-200">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
            <a href="{{ route('dashboard') }}" class="inline-block mb-4">
                <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-500">
                    P<span class="text-white">ortify.</span>
                </span>
            </a>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Name Your Masterpiece 
            </h2>
            <p class="mt-2 text-sm text-slate-400">
                Give your new portfolio a catchy title to get started.
            </p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-slate-800 py-8 px-4 shadow-2xl shadow-purple-900/20 sm:rounded-2xl sm:px-10 border border-slate-700 relative overflow-hidden">
                
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 rounded-full bg-purple-500 opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-blue-500 opacity-10 blur-2xl"></div>

                <div class="relative z-10">
                    <div class="flex justify-center mb-6">
                        <div class="h-16 w-16 bg-slate-700 rounded-full flex items-center justify-center shadow-inner">
                            <svg class="h-8 w-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                    </div>

                    <form action="{{ route('portfolios.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <input type="hidden" name="template_id" value="{{ request('template_id') }}">

                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-300">
                                Portfolio Title
                            </label>
                            <div class="mt-1">
                                <input id="title" name="title" type="text" required autofocus 
                                    class="appearance-none block w-full px-4 py-3 border border-slate-600 rounded-xl bg-slate-900 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all shadow-sm"
                                    placeholder="e.g., My Awesome Design Portfolio 2025">
                            </div>
                        </div>

                        <div class="flex items-center justify-center gap-2 text-xs text-slate-500 bg-slate-900/50 py-2 rounded-lg border border-slate-700/50">
                            <span>You selected Template ID:</span>
                            <span class="font-bold text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded">#{{ request('template_id') }}</span>
                        </div>

                        <div class="flex gap-4 pt-2">
                            <a href="{{ route('templates.index') }}" class="w-1/3 flex justify-center py-3 px-4 border border-slate-600 rounded-xl shadow-sm text-sm font-medium text-slate-300 bg-transparent hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                                Cancel
                            </a>
                            
                            <button type="submit" class="w-2/3 flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:-translate-y-0.5 transition-all">
                                Create & Start Editing →
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="mt-6 text-center text-xs text-slate-500">
                You can change this title anytime later from your dashboard.
            </p>
        </div>
    </div>
</x-app-layout>