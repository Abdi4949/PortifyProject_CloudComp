<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Details: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- User Info Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold mb-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="text-sm text-gray-600">Role</span>
                                <span class="font-semibold">{{ ucfirst($user->role) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="text-sm text-gray-600">Subscription</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->subscription_type === 'pro' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->subscription_type) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="text-sm text-gray-600">Joined</span>
                                <span class="font-semibold text-sm">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="space-y-2">
                            @if($user->status === 'active' && !$user->isAdmin())
                            <button onclick="openUpgradeModal()" class="w-full px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition text-sm">
                                ⭐ Upgrade to Pro
                            </button>
                            @endif
                            
                            @if(!$user->isAdmin())
                                @if($user->status === 'active')
                                <button onclick="openSuspendModal()" class="w-full px-4 py-2 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition text-sm">
                                    🚫 Suspend User
                                </button>
                                @else
                                <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-600 rounded-xl hover:bg-green-200 transition text-sm">
                                        ✅ Activate User
                                    </button>
                                </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stats & Activity -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white rounded-2xl shadow-sm p-4">
                            <p class="text-2xl font-bold text-blue-600">{{ $user->portfolios->count() }}</p>
                            <p class="text-xs text-gray-600">Portfolios</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm p-4">
                            <p class="text-2xl font-bold text-green-600">{{ $user->export_count }}</p>
                            <p class="text-xs text-gray-600">Total Exports</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm p-4">
                            <p class="text-2xl font-bold text-purple-600">{{ $user->transactions->count() }}</p>
                            <p class="text-xs text-gray-600">Transactions</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm p-4">
                            <p class="text-2xl font-bold text-yellow-600">{{ $user->activityLogs->count() }}</p>
                            <p class="text-xs text-gray-600">Activities</p>
                        </div>
                    </div>

                    <!-- Recent Portfolios -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold mb-4">Recent Portfolios</h3>
                        @if($user->portfolios->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->portfolios->take(5) as $portfolio)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <div>
                                    <p class="font-semibold text-sm">{{ $portfolio->title }}</p>
                                    <p class="text-xs text-gray-500">Template: {{ $portfolio->template->name }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $portfolio->created_at->diffForHumans() }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-gray-500 py-8">No portfolios yet</p>
                        @endif
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
                        @if($user->activityLogs->count() > 0)
                        <div class="space-y-2">
                            @foreach($user->activityLogs->take(10) as $log)
                            <div class="flex items-start gap-3 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $log->level === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($log->type) }}
                                </span>
                                <div class="flex-1">
                                    <p class="text-gray-700">{{ $log->description }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-gray-500 py-8">No activity yet</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Upgrade Modal -->
    <div id="upgradeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold mb-4">Upgrade User to Pro</h3>
            <form action="{{ route('admin.users.upgrade-pro', $user->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (months)</label>
                    <select name="duration_months" class="w-full rounded-xl border-gray-300" required>
                        <option value="1">1 Month</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months (1 Year)</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeUpgradeModal()" class="flex-1 px-4 py-2 bg-gray-100 rounded-xl">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-xl">Upgrade</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Suspend Modal -->
    <div id="suspendModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold mb-4">Suspend User</h3>
            <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                    <textarea name="suspend_reason" rows="3" class="w-full rounded-xl border-gray-300" required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeSuspendModal()" class="flex-1 px-4 py-2 bg-gray-100 rounded-xl">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-xl">Suspend</button>
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