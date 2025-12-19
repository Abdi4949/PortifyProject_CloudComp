<x-app-layout>
    <div class="py-10 bg-gray-900 min-h-screen text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 flex justify-between items-center px-4 sm:px-0">
                <div>
                    <h2 class="text-2xl font-bold text-white">Dashboard Overview</h2>
                    <p class="text-sm text-gray-400">Welcome back! Here's what's happening with your platform today.</p>
                </div>
                <div class="hidden sm:block">
                    <span class="text-sm text-gray-300 bg-gray-800 px-3 py-1 rounded-md shadow-sm border border-gray-700">
                        Last updated: {{ now()->format('H:i A') }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-gray-800 overflow-hidden rounded-xl shadow-lg border border-gray-700 transition duration-300 hover:border-gray-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-400 mb-1">Total Users</p>
                                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_users']) }}</p>
                            </div>
                            <div class="p-3 bg-blue-900/50 rounded-lg">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-xs">
                            <span class="px-2 py-0.5 rounded-full bg-green-900/50 text-green-400 border border-green-800 font-medium mr-2">
                                {{ $stats['pro_users'] }} Pro
                            </span>
                            <span class="text-gray-500">{{ $stats['free_users'] }} Free accounts</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 overflow-hidden rounded-xl shadow-lg border border-gray-700 transition duration-300 hover:border-gray-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-400 mb-1">Active Portfolios</p>
                                <p class="text-3xl font-bold text-white">{{ number_format($stats['total_portfolios']) }}</p>
                            </div>
                            <div class="p-3 bg-indigo-900/50 rounded-lg">
                                <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-500">
                            Based on <span class="font-semibold text-gray-300">{{ $stats['total_templates'] }}</span> available templates
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 overflow-hidden rounded-xl shadow-lg border border-gray-700 transition duration-300 hover:border-gray-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-400 mb-1">Total Revenue</p>
                                <p class="text-2xl font-bold text-white">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-emerald-900/50 rounded-lg">
                                <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-500">
                            From <span class="font-semibold text-gray-300">{{ $stats['total_transactions'] }}</span> total transactions
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 overflow-hidden rounded-xl shadow-lg border border-gray-700 transition duration-300 hover:border-gray-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-400 mb-1">Pending Approval</p>
                                <p class="text-3xl font-bold text-white">{{ $stats['pending_transactions'] }}</p>
                            </div>
                            <div class="p-3 bg-orange-900/50 rounded-lg">
                                <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-orange-400 font-medium">
                            Action required for these items
                        </div>
                    </div>
                </div>
            </div>

            @if($exportLogs->count() > 0)
            <div class="mb-8 bg-gradient-to-r from-amber-900/40 to-yellow-900/40 border border-amber-700/50 rounded-xl p-6 shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4 w-full">
                        <h3 class="text-lg font-bold text-amber-400">🎯 High Potential Leads (Export Limit Reached)</h3>
                        <p class="text-sm text-amber-200/80 mt-1 mb-4">These users have hit their free limits.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($exportLogs->take(6) as $log)
                            <div class="flex items-center justify-between bg-gray-900/60 rounded-lg p-3 border border-amber-800/50">
                                <div class="truncate mr-2">
                                    <p class="text-sm font-semibold text-gray-200 truncate">{{ $log->user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $log->user->email }}</p>
                                </div>
                                <span class="text-xs font-mono text-amber-500 whitespace-nowrap">{{ $log->created_at->diffForHumans(null, true) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-700 bg-gray-800/50">
                            <h3 class="text-lg font-bold text-white">Quick Actions</h3>
                        </div>
                        <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="group flex flex-col items-center p-4 bg-gray-700/50 border border-gray-600 rounded-xl hover:border-blue-500 hover:bg-gray-700 hover:-translate-y-1 transition-all duration-200">
                                <div class="h-10 w-10 bg-blue-900/30 rounded-full flex items-center justify-center group-hover:bg-blue-900/50 transition">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <span class="mt-3 text-sm font-medium text-gray-300 group-hover:text-blue-400">Users</span>
                            </a>

                            <a href="{{ route('admin.templates.index') }}" class="group flex flex-col items-center p-4 bg-gray-700/50 border border-gray-600 rounded-xl hover:border-purple-500 hover:bg-gray-700 hover:-translate-y-1 transition-all duration-200">
                                <div class="h-10 w-10 bg-purple-900/30 rounded-full flex items-center justify-center group-hover:bg-purple-900/50 transition">
                                    <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5z"></path>
                                    </svg>
                                </div>
                                <span class="mt-3 text-sm font-medium text-gray-300 group-hover:text-purple-400">Templates</span>
                            </a>

                            <a href="{{ route('admin.transactions.index') }}" class="group flex flex-col items-center p-4 bg-gray-700/50 border border-gray-600 rounded-xl hover:border-green-500 hover:bg-gray-700 hover:-translate-y-1 transition-all duration-200">
                                <div class="h-10 w-10 bg-green-900/30 rounded-full flex items-center justify-center group-hover:bg-green-900/50 transition">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <span class="mt-3 text-sm font-medium text-gray-300 group-hover:text-green-400">Transactions</span>
                            </a>

                            <a href="{{ route('admin.logs.index') }}" class="group flex flex-col items-center p-4 bg-gray-700/50 border border-gray-600 rounded-xl hover:border-yellow-500 hover:bg-gray-700 hover:-translate-y-1 transition-all duration-200">
                                <div class="h-10 w-10 bg-yellow-900/30 rounded-full flex items-center justify-center group-hover:bg-yellow-900/50 transition">
                                    <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="mt-3 text-sm font-medium text-gray-300 group-hover:text-yellow-400">Logs</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-white">Recent Transactions</h3>
                            <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-400 hover:text-blue-300 font-medium">View All</a>
                        </div>
                        <div class="divide-y divide-gray-700">
                            @forelse($recentTransactions as $transaction)
                            <div class="p-4 hover:bg-gray-700/50 transition flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-gray-700 rounded-full">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white text-sm">{{ $transaction->user->name }}</p>
                                        <p class="text-xs text-gray-500">Order #{{ $transaction->order_id }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-white text-sm">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        {{ $transaction->status === 'success' ? 'bg-green-900/50 text-green-400 border border-green-800' : 
                                           ($transaction->status === 'pending' ? 'bg-yellow-900/50 text-yellow-400 border border-yellow-800' : 'bg-red-900/50 text-red-400 border border-red-800') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="p-8 text-center text-gray-500 text-sm">No transactions found</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-8">
                    
                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-white">New Users</h3>
                            <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-400 hover:text-blue-300 font-bold uppercase tracking-wide">All Users</a>
                        </div>
                        <div class="divide-y divide-gray-700">
                            @forelse($recentUsers as $user)
                            <div class="p-4 hover:bg-gray-700/50 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gray-700 flex items-center justify-center text-gray-300 text-xs font-bold border border-gray-600">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-white truncate">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500 truncate w-32">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-[10px] font-semibold rounded-full uppercase tracking-wide border
                                        {{ $user->subscription_type === 'pro' ? 'bg-purple-900/50 text-purple-400 border-purple-800' : 'bg-gray-700 text-gray-400 border-gray-600' }}">
                                        {{ $user->subscription_type }}
                                    </span>
                                </div>
                                <div class="mt-2 text-right">
                                    <p class="text-[10px] text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="p-8 text-center text-gray-500 text-sm">No new users</div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>