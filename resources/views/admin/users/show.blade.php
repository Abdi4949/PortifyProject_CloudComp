<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen relative overflow-hidden text-gray-100">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-6 relative overflow-hidden">
                        
                        <div class="text-center mb-8 relative z-10">
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full mx-auto flex items-center justify-center text-white text-4xl font-bold mb-4 shadow-lg shadow-purple-900/50 border-4 border-gray-800">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center py-3 border-b border-gray-700">
                                <span class="text-sm text-gray-400">Role</span>
                                <span class="font-semibold text-white">{{ ucfirst($user->role) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-700">
                                <span class="text-sm text-gray-400">Subscription</span>
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border
                                    {{ $user->subscription_type === 'pro' 
                                        ? 'bg-purple-900/30 text-purple-300 border-purple-500/30' 
                                        : 'bg-gray-700 text-gray-400 border-gray-600' }}">
                                    {{ ucfirst($user->subscription_type) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-700">
                                <span class="text-sm text-gray-400">Status</span>
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border
                                    {{ $user->status === 'active' 
                                        ? 'bg-green-900/30 text-green-300 border-green-500/30' 
                                        : 'bg-red-900/30 text-red-300 border-red-500/30' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-700">
                                <span class="text-sm text-gray-400">Joined</span>
                                <span class="font-semibold text-sm text-white">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if($user->status === 'active' && !$user->isAdmin())
                            <button onclick="openUpgradeModal()" class="w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:from-purple-700 hover:to-pink-700 transition text-sm font-bold shadow-lg shadow-purple-900/30 flex justify-center items-center gap-2">
                                <span>⭐</span> Upgrade to Pro
                            </button>
                            @endif
                            
                            @if(!$user->isAdmin())
                                @if($user->status === 'active')
                                <button onclick="openSuspendModal()" class="w-full px-4 py-3 bg-red-900/20 text-red-400 border border-red-900/50 rounded-xl hover:bg-red-900/40 transition text-sm font-semibold flex justify-center items-center gap-2">
                                    <span>🚫</span> Suspend User
                                </button>
                                @else
                                <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-3 bg-green-900/20 text-green-400 border border-green-900/50 rounded-xl hover:bg-green-900/40 transition text-sm font-semibold flex justify-center items-center gap-2">
                                        <span>✅</span> Activate User
                                    </button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-lg">
                            <p class="text-3xl font-bold text-blue-400 mb-1">{{ $user->portfolios->count() }}</p>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Portfolios</p>
                        </div>
                        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-lg">
                            <p class="text-3xl font-bold text-green-400 mb-1">{{ $user->export_count }}</p>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Exports</p>
                        </div>
                        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-lg">
                            <p class="text-3xl font-bold text-purple-400 mb-1">{{ $user->transactions->count() }}</p>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Transactions</p>
                        </div>
                        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-lg">
                            <p class="text-3xl font-bold text-yellow-400 mb-1">{{ $user->activityLogs->count() }}</p>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Activities</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-6">
                        <h3 class="text-lg font-bold mb-6 text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Recent Portfolios
                        </h3>
                        @if($user->portfolios->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->portfolios->take(5) as $portfolio)
                            <div class="flex justify-between items-center p-4 bg-gray-700/30 rounded-xl border border-gray-700 hover:bg-gray-700/50 transition">
                                <div>
                                    <p class="font-semibold text-sm text-gray-200">{{ $portfolio->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Template: <span class="text-purple-400">{{ $portfolio->template->name }}</span></p>
                                </div>
                                <span class="text-xs text-gray-500 font-mono">{{ $portfolio->created_at->diffForHumans() }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8 bg-gray-700/20 rounded-xl border border-dashed border-gray-700">
                            <p class="text-gray-500 text-sm">No portfolios created yet.</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl p-6">
                        <h3 class="text-lg font-bold mb-6 text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Recent Activity
                        </h3>
                        @if($user->activityLogs->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->activityLogs->take(10) as $log)
                            <div class="flex items-start gap-4 text-sm group">
                                <span class="mt-0.5 px-2 py-0.5 text-[10px] font-bold uppercase rounded border 
                                    {{ $log->level === 'warning' 
                                        ? 'bg-yellow-900/30 text-yellow-500 border-yellow-500/30' 
                                        : 'bg-blue-900/30 text-blue-400 border-blue-500/30' }}">
                                    {{ ucfirst($log->type) }}
                                </span>
                                <div class="flex-1 pb-4 border-b border-gray-700/50 group-last:border-0 group-last:pb-0">
                                    <p class="text-gray-300">{{ $log->description }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8 bg-gray-700/20 rounded-xl border border-dashed border-gray-700">
                            <p class="text-gray-500 text-sm">No activity recorded yet.</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div id="upgradeModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl max-w-md w-full p-6 shadow-2xl transform transition-all">
            <h3 class="text-xl font-bold mb-2 text-white">Upgrade User to Pro</h3>
            <p class="text-gray-400 text-sm mb-6">Select the duration to grant Pro access.</p>
            
            <form action="{{ route('admin.users.upgrade-pro', $user->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Duration</label>
                    <select name="duration_months" class="w-full rounded-xl bg-gray-900 border-gray-600 text-white focus:border-purple-500 focus:ring-purple-500" required>
                        <option value="1">1 Month</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months (1 Year)</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeUpgradeModal()" class="flex-1 px-4 py-2.5 bg-gray-700 text-gray-300 rounded-xl hover:bg-gray-600 transition font-medium">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:from-purple-700 hover:to-pink-700 transition font-medium shadow-lg shadow-purple-900/40">Upgrade</button>
                </div>
            </form>
        </div>
    </div>

    <div id="suspendModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="text-xl font-bold mb-2 text-white">Suspend User</h3>
            <p class="text-gray-400 text-sm mb-6">This action will prevent the user from logging in.</p>
            
            <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Reason</label>
                    <textarea name="suspend_reason" rows="3" class="w-full rounded-xl bg-gray-900 border-gray-600 text-white placeholder-gray-500 focus:border-red-500 focus:ring-red-500" placeholder="E.g., Violation of terms..." required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeSuspendModal()" class="flex-1 px-4 py-2.5 bg-gray-700 text-gray-300 rounded-xl hover:bg-gray-600 transition font-medium">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-medium shadow-lg shadow-red-900/40">Suspend</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUpgradeModal() { document.getElementById('upgradeModal').classList.remove('hidden'); }
        function closeUpgradeModal() { document.getElementById('upgradeModal').classList.add('hidden'); }
        function openSuspendModal() { document.getElementById('suspendModal').classList.remove('hidden'); }
        function closeSuspendModal() { document.getElementById('suspendModal').classList.add('hidden'); }
    </script>
</x-app-layout>