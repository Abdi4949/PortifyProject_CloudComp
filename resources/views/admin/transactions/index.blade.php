<x-app-layout>
    <div class="min-h-screen bg-[#0f172a] text-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="relative bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 rounded-3xl p-10 mb-10 shadow-2xl shadow-purple-900/20 overflow-hidden border border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 rounded-full bg-blue-500 opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-72 h-72 rounded-full bg-pink-500 opacity-20 blur-3xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold text-white mb-2 tracking-tight">
                        Transaction History 
                    </h2>
                    <p class="text-purple-100 text-lg opacity-90">
                        Monitor all payments and subscription activities.
                    </p>
                </div>

                <div class="relative z-10 flex gap-4">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 px-6 py-3 rounded-xl text-white font-bold shadow-lg">
                        Total Income: <span class="text-emerald-300">Rp {{ number_format($transactions->sum('amount') ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 rounded-3xl shadow-xl border border-slate-700 overflow-hidden">
                
                @if($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-700/50 text-slate-400 uppercase text-xs tracking-wider font-bold">
                                    <th class="p-6 border-b border-slate-700">ID</th>
                                    <th class="p-6 border-b border-slate-700">User</th>
                                    <th class="p-6 border-b border-slate-700">Plan</th>
                                    <th class="p-6 border-b border-slate-700">Amount</th>
                                    <th class="p-6 border-b border-slate-700">Status</th>
                                    <th class="p-6 border-b border-slate-700">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($transactions as $trx)
                                    <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                        <td class="p-6 text-slate-400 font-mono text-sm">#{{ substr($trx->id, 0, 8) }}...</td>
                                        <td class="p-6">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-xs mr-3">
                                                    {{ substr($trx->user->name ?? 'U', 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-white text-sm">{{ $trx->user->name ?? 'Unknown User' }}</div>
                                                    <div class="text-xs text-slate-500">{{ $trx->user->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-6 text-slate-300 font-medium">
                                            {{ ucfirst(str_replace('_', ' ', $trx->plan ?? 'Pro Plan')) }}
                                        </td>
                                        <td class="p-6 text-white font-bold">
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="p-6">
                                            @if($trx->status == 'paid' || $trx->status == 'success')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                    ● Success
                                                </span>
                                            @elseif($trx->status == 'pending')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                                    ● Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                                                    ● {{ ucfirst($trx->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-6 text-slate-400 text-sm">
                                            {{ $trx->created_at->format('M d, Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-slate-700 bg-slate-800">
                        {{ $transactions->links() }}
                    </div>

                @else
                    <div class="text-center py-20">
                        <div class="bg-slate-700/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Transactions Yet</h3>
                        <p class="text-slate-400">Transaction history will appear here once users make purchases.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>