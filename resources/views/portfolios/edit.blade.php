<x-app-layout>
    
    @if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="fixed top-24 right-5 z-50 max-w-sm w-full bg-white shadow-xl rounded-xl border-l-4 border-green-500 p-4 transition duration-500">
        <div class="flex items-start">
            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <div>
                <p class="font-bold text-gray-900">Success!</p>
                <p class="text-sm text-gray-500">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="min-h-screen bg-gray-100 pb-20">
        
        <div class="bg-white border-b border-gray-200 sticky top-16 z-40 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Editing: {{ $portfolio->title }}</h1>
                    <p class="text-sm text-gray-500">Template ID: #{{ $portfolio->template_id }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('portfolios.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg font-bold hover:bg-gray-200 transition">Cancel</a>
                    
                    <button form="portfolio-form" name="action" value="save" type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 shadow-md transition transform hover:scale-105">
                        Save Changes
                    </button>

                    <a href="{{ route('portfolios.show', $portfolio->id) }}" target="_blank" class="px-4 py-2 border border-purple-200 text-purple-600 rounded-lg font-bold hover:bg-purple-50 flex items-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Preview
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Whoops! Ada masalah saat menyimpan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="portfolio-form" action="{{ route('portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">1. General Settings</h2>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Portfolio Title</label>
                    <input type="text" name="portfolio_title" value="{{ old('portfolio_title', $portfolio->title) }}" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">2. Personal Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2 flex flex-col items-center justify-center mb-4 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <div x-data="{ photoName: null, photoPreview: null }">
                                <input type="file" class="hidden" x-ref="profile_photo" name="profile_image"
                                        @change="
                                            const file = $refs.profile_photo.files[0];
                                            const reader = new FileReader();
                                            reader.onload = (e) => { photoPreview = e.target.result; };
                                            reader.readAsDataURL(file);
                                        ">
                                
                                <input type="hidden" name="old_profile_image" value="{{ $content['profile']['image'] ?? '' }}">

                                <div class="mt-2 text-center" x-show="!photoPreview">
                                    @if(isset($content['profile']['image']) && $content['profile']['image'])
                                        <img src="{{ asset('storage/' . $content['profile']['image']) }}" 
                                             class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-purple-100 shadow-md">
                                    @else
                                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 flex items-center justify-center text-gray-400 border-4 border-white shadow-md">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-2" x-show="photoPreview" style="display: none;">
                                    <span class="block w-32 h-32 mx-auto rounded-full bg-cover bg-center border-4 border-purple-100 shadow-md"
                                          :style="'background-image: url(\'' + photoPreview + '\');'">
                                    </span>
                                </div>

                                <button type="button" @click="$refs.profile_photo.click()" class="mt-4 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 shadow-sm">
                                    Change Profile Photo
                                </button>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" value="{{ $content['profile']['name'] ?? Auth::user()->name }}" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Role / Job Title</label>
                            <input type="text" name="role" value="{{ $content['profile']['role'] ?? '' }}" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="e.g. UX Designer">
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="Tell us about yourself...">{{ $content['profile']['bio'] ?? '' }}</textarea>
                        </div>
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ $content['profile']['email'] ?? Auth::user()->email }}" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                            <input type="url" name="linkedin" value="{{ $content['profile']['linkedin'] ?? '' }}" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <label class="block text-sm font-medium text-gray-700">GitHub URL (Optional)</label>
                            <input type="url" name="github" value="{{ $content['profile']['github'] ?? '' }}" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">3. Skills</h2>
                    <label class="block text-sm font-medium text-gray-700 mb-2">List your skills (separated by comma)</label>
                    <textarea name="skills" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="HTML, CSS, PHP, Laravel...">{{ implode(', ', $content['skills'] ?? []) }}</textarea>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-8" x-data="{ 
                    projects: {{ json_encode($content['projects'] ?? [['title' => '', 'description' => '', 'link' => '', 'image' => null]]) }} 
                }">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-900">4. Projects Showcase</h2>
                        <button type="button" @click="projects.push({title: '', description: '', link: '', image: null})" class="text-sm bg-purple-50 text-purple-700 hover:bg-purple-100 font-bold px-4 py-2 rounded-lg border border-purple-200 transition">
                            + Add Project
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(project, index) in projects" :key="index">
                            <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 relative group hover:shadow-md transition">
                                <button type="button" @click="projects = projects.filter((p, i) => i !== index)" class="absolute top-4 right-4 text-red-400 hover:text-red-600 z-10 p-1 bg-white rounded-full shadow-sm hover:bg-red-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div x-data="{ photoName: null, photoPreview: null }">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Project Image</label>
                                        
                                        <input type="hidden" :name="'projects[' + index + '][old_image]'" :value="project.image">

                                        <input type="file" class="hidden" x-ref="photo" 
                                               :name="'projects[' + index + '][image]'"
                                               @change="
                                                   const file = $refs.photo.files[0];
                                                   photoName = file.name;
                                                   const reader = new FileReader();
                                                   reader.onload = (e) => { photoPreview = e.target.result; };
                                                   reader.readAsDataURL(file);
                                               ">

                                        <div class="mt-2" x-show="!photoPreview && project.image">
                                            <img :src="'/storage/' + project.image" 
                                                 class="h-40 w-full object-cover rounded-lg border border-gray-300"
                                                 alt="Project Image"
                                                 onerror="this.style.display='none'"> 
                                        </div>

                                        <div class="mt-2" x-show="photoPreview" style="display: none;">
                                            <span class="block h-40 w-full rounded-lg bg-cover bg-center border border-gray-300"
                                                  :style="'background-image: url(\'' + photoPreview + '\');'">
                                            </span>
                                        </div>

                                        <button type="button" @click="$refs.photo.click()" class="mt-3 w-full py-2 bg-white border border-gray-300 rounded-md text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                                            Select Image
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <input type="text" :name="'projects[' + index + '][title]'" x-model="project.title" placeholder="Project Name" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                                        <textarea :name="'projects[' + index + '][description]'" x-model="project.description" rows="3" placeholder="Description" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500"></textarea>
                                        <input type="url" :name="'projects[' + index + '][link]'" x-model="project.link" placeholder="https://..." class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>