<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8">
                
                <div class="text-center mb-8">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Name Your Project 🚀</h2>
                    <p class="text-gray-500 mt-2">Give your new portfolio a catchy title to get started.</p>
                </div>

                <form action="{{ route('portfolios.store') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="template_id" value="{{ $templateId }}">

                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Portfolio Title</label>
                        <input type="text" name="title" id="title" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                               placeholder="e.g., My Awesome Design Portfolio 2025">
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('templates.index') }}" class="w-1/3 py-3 px-4 text-center rounded-lg font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                            Cancel
                        </a>
                        <button type="submit" class="w-2/3 py-3 px-4 rounded-lg font-bold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg hover:scale-[1.02] transition-transform">
                            Create & Start Editing →
                        </button>
                    </div>
                </form>

            </div>
            
            <div class="text-center mt-6 text-sm text-gray-400">
                You selected Template ID: <span class="font-mono bg-gray-200 px-2 py-1 rounded text-gray-600">#{{ $templateId }}</span>
            </div>

        </div>
    </div>
</x-app-layout>