<x-app-layout>
    <div class="min-h-screen bg-[#0f172a] text-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Template Management 🎨</h2>
                    <p class="text-slate-400 mt-1">Manage availability of portfolio templates.</p>
                </div>
                <button class="bg-slate-700 text-slate-400 px-4 py-2 rounded-lg text-sm font-bold cursor-not-allowed opacity-50">
                    + Add New Template (Next Update)
                </button>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl flex items-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-700/50 text-slate-400 uppercase text-xs tracking-wider font-bold">
                                <th class="p-5 border-b border-slate-700">ID</th>
                                <th class="p-5 border-b border-slate-700">Preview</th>
                                <th class="p-5 border-b border-slate-700">Name & Layout</th>
                                <th class="p-5 border-b border-slate-700">Type</th>
                                <th class="p-5 border-b border-slate-700">Status</th>
                                <th class="p-5 border-b border-slate-700 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @foreach($templates as $template)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="p-5 font-mono text-sm text-slate-500">#{{ $template->id }}</td>
                                    
                                    <td class="p-5">
                                        <div class="w-16 h-12 bg-slate-900 rounded overflow-hidden relative border border-slate-600">
                                            <div class="w-[400%] h-[400%] origin-top-left transform scale-[0.25] pointer-events-none">
                                                <iframe src="{{ route('templates.show', $template->id) }}" class="w-full h-full border-0"></iframe>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-5">
                                        <div class="font-bold text-white">{{ $template->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $template->layout }}</div>
                                    </td>

                                    <td class="p-5">
                                        @if($template->is_premium)
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20">PRO</span>
                                        @else
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">FREE</span>
                                        @endif
                                    </td>

                                    <td class="p-5">
                                        @if($template->is_published)
                                            <span class="flex items-center gap-2 text-emerald-400 text-sm font-bold">
                                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Published
                                            </span>
                                        @else
                                            <span class="flex items-center gap-2 text-slate-500 text-sm font-bold">
                                                <span class="w-2 h-2 rounded-full bg-slate-500"></span> Hidden
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-5 text-right">
                                        <form action="{{ route('admin.templates.toggle', $template->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            
                                            @if($template->is_published)
                                                <button type="submit" class="text-xs font-bold text-red-400 hover:text-white border border-red-500/30 hover:bg-red-500 px-3 py-1.5 rounded-lg transition-all">
                                                    Unpublish
                                                </button>
                                            @else
                                                <button type="submit" class="text-xs font-bold text-emerald-400 hover:text-white border border-emerald-500/30 hover:bg-emerald-500 px-3 py-1.5 rounded-lg transition-all">
                                                    Publish Now
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>