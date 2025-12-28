<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen relative overflow-hidden text-gray-100">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-pink-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            @if(session('success'))
            <div class="bg-green-900/50 border-l-4 border-green-500 p-4 mb-6 rounded-lg backdrop-blur-sm">
                <p class="text-sm text-green-300 font-medium">✅ {{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-900/50 border-l-4 border-red-500 p-4 mb-6 rounded-lg backdrop-blur-sm">
                <p class="text-sm text-red-300 font-medium">❌ {{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-6 mb-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search by name or email..." 
                            value="{{ request('search') }}"
                            class="w-full rounded-xl bg-gray-900 border-gray-600 text-white placeholder-gray-500 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition"
                        >
                    </div>

                    <div>
                        <select name="subscription" class="rounded-xl bg-gray-900 border-gray-600 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition">
                            <option value="all" {{ request('subscription') === 'all' ? 'selected' : '' }}>All Subscriptions</option>
                            <option value="free" {{ request('subscription') === 'free' ? 'selected' : '' }}>Free</option>
                            <option value="pro" {{ request('subscription') === 'pro' ? 'selected' : '' }}>Pro</option>
                        </select>
                    </div>

                    <div>
                        <select name="status" class="rounded-xl bg-gray-900 border-gray-600 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition">
                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-pink-700 shadow-lg shadow-purple-900/20 transition">
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'subscription', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-700 text-gray-300 font-medium rounded-xl hover:bg-gray-600 transition border border-gray-600">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Subscription</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Portfolios</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Exports</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-700/50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-900/50 text-purple-300 flex items-center justify-center text-xs font-bold mr-3 border border-purple-500/30">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full border 
                                        {{ $user->subscription_type === 'pro' 
                                            ? 'bg-purple-900/30 text-purple-300 border-purple-500/30' 
                                            : 'bg-gray-700 text-gray-400 border-gray-600' }}">
                                        {{ ucfirst($user->subscription_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full border
                                        {{ $user->status === 'active' 
                                            ? 'bg-green-900/30 text-green-400 border-green-500/30' 
                                            : 'bg-red-900/30 text-red-400 border-red-500/30' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $user->portfolios->count() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $user->export_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-3">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="text-purple-400 hover:text-purple-300 transition">View</a>
                                        
                                        @if($user->status === 'active')
                                        <button onclick="openSuspendModal({{ $user->id }}, '{{ $user->name }}')" class="text-red-400 hover:text-red-300 transition">
                                            Suspend
                                        </button>
                                        @else
                                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-400 hover:text-green-300 transition">Activate</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p>No users found matching your filters</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-700 bg-gray-800">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    <div id="suspendModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl max-w-md w-full p-6 shadow-2xl">
            <h3 class="text-xl font-bold mb-4 text-white">Suspend User</h3>
            <p class="text-gray-300 mb-4">Are you sure you want to suspend <strong id="suspendUserName" class="text-white"></strong>?</p>
            
            <form id="suspendForm" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Reason for suspension</label>
                    <textarea 
                        name="suspend_reason" 
                        rows="3" 
                        required
                        class="w-full rounded-xl bg-gray-900 border-gray-600 text-white placeholder-gray-500 shadow-sm focus:border-red-500 focus:ring-red-500"
                        placeholder="Enter reason..."
                    ></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeSuspendModal()" class="flex-1 px-4 py-2.5 bg-gray-700 text-gray-300 rounded-xl hover:bg-gray-600 transition font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-medium shadow-lg shadow-red-900/20">
                        Suspend User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openSuspendModal(userId, userName) {
            document.getElementById('suspendModal').classList.remove('hidden');
            document.getElementById('suspendUserName').textContent = userName;
            document.getElementById('suspendForm').action = `/admin/users/${userId}/suspend`;
        }

        function closeSuspendModal() {
            document.getElementById('suspendModal').classList.add('hidden');
        }
    </script>
</x-app-layout>