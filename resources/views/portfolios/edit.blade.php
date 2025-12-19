<x-app-layout>
    <div class="min-h-screen bg-[#0f172a] text-slate-200 pb-20">
        
        <div class="sticky top-0 z-30 bg-[#0f172a]/80 backdrop-blur-md border-b border-slate-700 shadow-lg transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <div class="flex items-center gap-3">
                        <div class="hidden md:flex p-2 bg-slate-800 rounded-lg border border-slate-700 shadow-sm">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white leading-tight">
                                Editing: <span class="text-purple-400">{{ $portfolio->title }}</span>
                            </h2>
                            <p class="text-xs text-slate-400 font-mono">Template ID: #{{ $portfolio->template_id }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('portfolios.index') }}" class="px-4 py-2 text-sm font-medium text-slate-400 hover:text-white transition-colors">
                            Cancel
                        </a>
                        
                        <button type="submit" form="edit-form" class="px-6 py-2 rounded-xl bg-purple-600 text-white text-sm font-bold shadow-lg shadow-purple-900/50 hover:bg-purple-500 hover:scale-105 transition-all flex items-center gap-2">
                            Save Changes
                        </button>

                        <a href="{{ route('portfolios.show', $portfolio->id) }}" target="_blank" class="px-5 py-2 rounded-xl bg-slate-800 border border-slate-600 text-purple-400 text-sm font-bold hover:bg-slate-700 hover:text-white transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Preview
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <form id="edit-form" action="{{ route('portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700 bg-slate-800/50">
                        <h3 class="text-lg font-bold text-white">1. General Settings</h3>
                    </div>
                    <div class="p-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Portfolio Title</label>
                            <input type="text" name="title" value="{{ old('title', $portfolio->title) }}" 
                                class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700 bg-slate-800/50">
                        <h3 class="text-lg font-bold text-white">2. Personal Information</h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div class="flex flex-col items-center justify-center">
                            @php 
                                $content = json_decode($portfolio->content, true) ?? [];
                                $profileImg = $content['profile']['image'] ?? null;
                            @endphp
                            
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-700 border-4 border-slate-600 shadow-lg mb-4 relative group">
                                <img id="profile-preview-img" src="{{ $profileImg ? asset('storage/' . $profileImg) : '' }}" class="w-full h-full object-cover {{ $profileImg ? '' : 'hidden' }}">
                                
                                <div id="profile-placeholder" class="w-full h-full flex items-center justify-center text-slate-500 {{ $profileImg ? 'hidden' : '' }}">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            </div>
                            
                            <label for="profile_image" class="cursor-pointer px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-sm text-white hover:bg-slate-600 transition-colors shadow-md">
                                Change Profile Photo
                            </label>
                            <input type="file" id="profile_image" name="profile[image]" class="hidden" accept="image/*" onchange="previewProfile(event)">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Full Name</label>
                                <input type="text" name="profile[name]" value="{{ $content['profile']['name'] ?? Auth::user()->name }}" 
                                    class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Role / Job Title</label>
                                <input type="text" name="profile[role]" value="{{ $content['profile']['role'] ?? '' }}" placeholder="e.g. UX Designer"
                                    class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-300 mb-2">Professional Bio</label>
                                <textarea name="profile[bio]" rows="4" 
                                    class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">{{ $content['profile']['bio'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-700">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                                <input type="email" name="profile[email]" value="{{ $content['profile']['email'] ?? Auth::user()->email }}"
                                    class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">LinkedIn / Website</label>
                                <input type="text" name="profile[linkedin]" value="{{ $content['profile']['linkedin'] ?? '' }}" placeholder="https://..."
                                    class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700 bg-slate-800/50">
                        <h3 class="text-lg font-bold text-white">3. Skills</h3>
                    </div>
                    <div class="p-6">
                        <div id="skills-container" class="space-y-3">
                            @php $skills = $content['skills'] ?? ['']; @endphp
                            @foreach($skills as $index => $skill)
                                <div class="flex gap-2">
                                    <input type="text" name="skills[]" value="{{ $skill }}" placeholder="Skill Name"
                                        class="flex-1 px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addSkill()" class="mt-4 px-4 py-2 bg-slate-700 text-white text-sm font-bold rounded-lg hover:bg-slate-600 transition-colors">
                            + Add Skill
                        </button>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-700 bg-slate-800/50">
                        <h3 class="text-lg font-bold text-white">4. Selected Projects</h3>
                    </div>
                    <div class="p-6">
                        <div id="projects-container" class="space-y-6">
                            @php $projects = $content['projects'] ?? [['title' => '', 'description' => '', 'link' => '']]; @endphp
                            @foreach($projects as $index => $project)
                                <div class="bg-slate-900 rounded-xl p-5 border border-slate-700 relative group project-item">
                                    <div class="absolute top-4 right-4 text-xs font-bold text-slate-500">PROJECT #{{ $index + 1 }}</div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Project Title</label>
                                            <input type="text" name="projects[{{ $index }}][title]" value="{{ $project['title'] }}"
                                                class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Description</label>
                                            <textarea name="projects[{{ $index }}][description]" rows="2"
                                                class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ $project['description'] }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Link</label>
                                            <input type="text" name="projects[{{ $index }}][link]" value="{{ $project['link'] }}"
                                                class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Image</label>
                                            
                                            <div class="mb-2">
                                                @if(!empty($project['image']))
                                                    <img src="{{ asset('storage/' . $project['image']) }}" class="h-20 w-auto rounded border border-slate-600 project-preview-img object-cover">
                                                @else
                                                    <img src="" class="h-20 w-auto rounded border border-slate-600 project-preview-img hidden object-cover">
                                                @endif
                                            </div>

                                            <input type="file" name="projects[{{ $index }}][image]" accept="image/*" onchange="previewProject(this)"
                                                class="text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-700 file:text-white hover:file:bg-slate-600">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addProject()" class="mt-6 w-full py-3 border-2 border-dashed border-slate-600 rounded-xl text-slate-400 font-bold hover:border-purple-500 hover:text-purple-400 hover:bg-slate-900 transition-all">
                            + Add New Project
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        // 1. Fungsi Preview Profile Image
        function previewProfile(event) {
            const input = event.target;
            const reader = new FileReader();
            
            reader.onload = function() {
                const img = document.getElementById('profile-preview-img');
                const placeholder = document.getElementById('profile-placeholder');
                
                img.src = reader.result;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        // 2. Fungsi Preview Project Image (Per Item)
        function previewProject(input) {
            const reader = new FileReader();
            
            reader.onload = function() {
                // Cari elemen img preview di dekat input file ini
                const previewImg = input.previousElementSibling.querySelector('.project-preview-img') || input.parentNode.querySelector('.project-preview-img');
                
                if (previewImg) {
                    previewImg.src = reader.result;
                    previewImg.classList.remove('hidden');
                }
            };
            
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        // 3. Fungsi Add Skill
        function addSkill() {
            const container = document.getElementById('skills-container');
            const input = document.createElement('div');
            input.className = 'flex gap-2';
            input.innerHTML = `
                <input type="text" name="skills[]" placeholder="New Skill..." class="flex-1 px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
            `;
            container.appendChild(input);
        }

        // 4. Fungsi Add Project
        function addProject() {
            const container = document.getElementById('projects-container');
            const index = container.children.length;
            const item = document.createElement('div');
            item.className = 'bg-slate-900 rounded-xl p-5 border border-slate-700 relative group mt-4 project-item';
            
            // Perhatikan: Menambahkan class 'project-preview-img hidden' untuk container baru
            item.innerHTML = `
                <div class="absolute top-4 right-4 text-xs font-bold text-slate-500">PROJECT #${index + 1}</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Project Title</label>
                        <input type="text" name="projects[${index}][title]" class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Description</label>
                        <textarea name="projects[${index}][description]" rows="2" class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Link</label>
                        <input type="text" name="projects[${index}][link]" class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Image</label>
                        
                        <div class="mb-2">
                             <img src="" class="h-20 w-auto rounded border border-slate-600 project-preview-img hidden object-cover">
                        </div>

                        <input type="file" name="projects[${index}][image]" accept="image/*" onchange="previewProject(this)" class="text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-700 file:text-white hover:file:bg-slate-600">
                    </div>
                </div>
            `;
            container.appendChild(item);
        }
    </script>
</x-app-layout>