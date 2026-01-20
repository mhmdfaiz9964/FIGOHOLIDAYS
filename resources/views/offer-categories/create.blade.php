<x-app-layout>
    <div x-data="{ 
        name: '',
        slug: '',
        sub_heading: '',
        preview: null,
        handleFile(e) {
            const file = e.target.files[0];
            if (file) this.preview = URL.createObjectURL(file);
        },
        updateSlug() {
            this.slug = this.name.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        }
    }" class="space-y-10 animate-in fade-in duration-700 pb-20">
        
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('offer-categories.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Create Category</h1>
                <p class="text-slate-400 mt-2 font-semibold">Define a new category and upload its primary banner.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Form Card -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10">
                <form action="{{ route('offer-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Category Name</label>
                            <input type="text" name="name" x-model="name" @input="updateSlug" required 
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="e.g. Honeymoon Special">
                            @error('name') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Category Slug</label>
                            <input type="text" name="slug" x-model="slug" required 
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-500 text-sm focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="honeymoon-special">
                            @error('slug') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Meta Title</label>
                            <input type="text" name="title" required 
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="A short catchy title for SEO">
                            @error('title') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Sub Heading</label>
                            <input type="text" name="sub_heading" x-model="sub_heading"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Secondary information for the banner">
                            @error('sub_heading') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Visibility Status</label>
                            <select name="status" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 transition-all outline-none appearance-none">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Banner Image (5MB Max)</label>
                            <input type="file" name="banner_image" @change="handleFile"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-400 cursor-pointer">
                            @error('banner_image') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black text-lg shadow-xl shadow-[#0F4A3B]/20 hover:opacity-95 transition-all">
                            Publish Category
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Card -->
            <div class="space-y-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-2">Visual Preview</p>
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden group">
                    <div class="relative h-64 bg-slate-900 overflow-hidden flex items-center justify-center">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <p class="text-[10px] font-black text-white/20 uppercase tracking-widest">Banner Placeholder</p>
                        </template>
                        <div class="absolute inset-0 bg-black/30"></div>
                        <div class="absolute bottom-8 left-8 text-white">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80" x-text="name ?: 'Category Tag'"></p>
                            <h3 class="text-3xl font-black mt-1" x-text="name ?: 'Category Name'"></h3>
                            <p class="text-sm font-bold mt-2 text-white/70" x-text="sub_heading"></p>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-emerald-100">Live Status</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight" x-text="'slug: ' + slug"></span>
                        </div>
                        <p class="text-sm font-bold text-slate-400">This is how the category meta-info will be stored and indexed by search engines.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
