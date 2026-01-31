<x-app-layout>
    <div x-data='{ 
        hero_data: {{ json_encode([
            "tag" => old("tag", $hero->tag ?: "Exclusive 2026 Offers"),
            "title" => old("title", $hero->title ?: "Sri Lanka through"),
            "highlight" => old("highlighted_title", $hero->highlighted_title ?: "Arab lensan"),
            "desc" => old("description", $hero->description ?: "Luxury trips designed specifically for the Gulf traveler."),
            "btn1" => old("btn1_text", $hero->btn1_text ?: "Free consultation"),
            "btn2" => old("btn2_text", $hero->btn2_text ?: "Browse our programs"),
            "tag_size" => old("tag_size", str_replace("px", "", $hero->tag_size ?: "14")),
            "title_size" => old("title_size", str_replace("px", "", $hero->title_size ?: "45")),
            "highlight_size" => old("highlight_size", str_replace("px", "", $hero->highlight_size ?: "45")),
            "description_size" => old("description_size", str_replace("px", "", $hero->description_size ?: "16")),
        ]) }},
        bg_previews: {!! json_encode(collect($hero->background_images ?? [])->map(fn($path) => Storage::url($path))->toArray()) !!},
        poster_preview: {{ json_encode($hero->background_image ? Storage::url($hero->background_image) : null) }},
        icon1_preview: {{ json_encode($hero->btn1_icon ? Storage::url($hero->btn1_icon) : null) }},
        icon2_preview: {{ json_encode($hero->btn2_icon ? Storage::url($hero->btn2_icon) : null) }},
        current_bg_index: 0,
        isUploading: false,
        
        handlePosterChange(e) {
            const file = e.target.files[0];
            if (file) this.poster_preview = URL.createObjectURL(file);
        },
        handleIcon1Change(e) {
            const file = e.target.files[0];
            if (file) this.icon1_preview = URL.createObjectURL(file);
        },
        handleIcon2Change(e) {
            const file = e.target.files[0];
            if (file) this.icon2_preview = URL.createObjectURL(file);
        },
        handleMultiBgChange(e) {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                this.bg_previews.push(URL.createObjectURL(files[i]));
            }
        },
        removeBg(index) {
            this.bg_previews.splice(index, 1);
        },
        init() {
            setInterval(() => {
                if(this.bg_previews.length > 0) {
                    this.current_bg_index = (this.current_bg_index + 1) % this.bg_previews.length;
                }
            }, 3000);
        }
    }' x-init='init()' class="space-y-10 animate-in fade-in duration-700 pb-20">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Home Page Banner Designer</h1>
                <p class="text-slate-400 mt-2 font-semibold">Customize headings, multiple background images, and font styles.</p>
            </div>
            <div class="bg-emerald-50 px-6 py-3 rounded-2xl border border-emerald-100">
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">System Status</p>
                <p class="text-sm font-bold text-emerald-800">Dynamic Multi-BG Active</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10 items-start">
            
            <!-- Editor Form -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <form action="{{ route('heroes.store') }}" method="POST" enctype="multipart/form-data" 
                    @submit="isUploading = true"
                    class="space-y-8">
                    @csrf
                    
                    <!-- Text Content -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Tag / Badge Text</label>
                                <input type="text" name="tag" x-model="hero_data.tag" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Tag Size (px)</label>
                                <input type="number" name="tag_size" x-model="hero_data.tag_size" min="0" max="100" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Main Title Text</label>
                                <input type="text" name="title" x-model="hero_data.title" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Title Size (px)</label>
                                <input type="number" name="title_size" x-model="hero_data.title_size" min="0" max="100" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Highlight Text (Gold)</label>
                                <input type="text" name="highlighted_title" x-model="hero_data.highlight" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Highlight Size (px)</label>
                                <input type="number" name="highlight_size" x-model="hero_data.highlight_size" min="0" max="100" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description</label>
                                <textarea name="description" x-model="hero_data.desc" rows="3" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none focus:bg-white transition-all"></textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description Size (px)</label>
                                <input type="number" name="description_size" x-model="hero_data.description_size" min="0" max="100" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Backgrounds Section -->
                    <div class="pt-8 border-t border-slate-50 space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-black text-[#0F4A3B] uppercase tracking-widest">Background Images (Multiple)</h3>
                            <div class="relative">
                                <button type="button" class="text-xs font-black text-[#0F4A3B] hover:opacity-70">+ Upload Images</button>
                                <input type="file" name="background_images[]" multiple @change="handleMultiBgChange" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <template x-for="(img, index) in bg_previews" :key="index">
                                <div class="relative aspect-video rounded-2xl overflow-hidden border-2 border-slate-100 group">
                                    <img :src="img" class="w-full h-full object-cover">
                                    <input type="hidden" name="existing_bg_images[]" :value="img.includes('storage') ? img.split('storage/')[1] : ''">
                                    <button type="button" @click="removeBg(index)" class="absolute top-2 right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">&times;</button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Posters & Icons -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-8 border-t border-slate-50">
                        <div class="space-y-4">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Poster Wallpaper (Fallback)</label>
                            <input type="file" name="background_image" @change="handlePosterChange" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-400">
                        </div>
                        
                        <div class="space-y-4">
                            <h4 class="text-xs font-black text-[#0F4A3B] uppercase tracking-widest">Buttons & Icons</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Btn 1 Icon</label>
                                    <input type="file" name="btn1_icon" @change="handleIcon1Change" class="w-full text-[10px] font-bold text-slate-300">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase">Btn 2 Icon</label>
                                    <input type="file" name="btn2_icon" @change="handleIcon2Change" class="w-full text-[10px] font-bold text-slate-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-[2rem] font-black text-lg shadow-2xl shadow-[#0F4A3B]/20 hover:scale-[1.01] transition-all">
                        Update Home Page Design
                    </button>
                </form>
            </div>

            <!-- Previews -->
            <div class="sticky top-10 space-y-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center gap-2 px-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Interactive Slideshow Preview
                </p>
                <div class="relative aspect-[16/9] rounded-[3.5rem] overflow-hidden shadow-2xl border-8 border-white bg-slate-900 group">
                    <!-- Background Images Slideshow -->
                    <template x-for="(img, index) in bg_previews" :key="index">
                        <img x-show="current_bg_index === index" :src="img" 
                             x-transition:enter="transition opacity duration-1000"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition opacity duration-1000"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 w-full h-full object-cover">
                    </template>
                    
                    <!-- Fallback to Poster if no multi-bg -->
                    <template x-if="bg_previews.length === 0 && poster_preview">
                        <img :src="poster_preview" class="absolute inset-0 w-full h-full object-cover">
                    </template>

                    <div class="absolute inset-0 bg-black/40"></div>

                    <!-- Layout Content -->
                    <div class="absolute inset-0 flex items-center justify-end px-12 text-right">
                        <div class="max-w-md space-y-6">
                            <div class="flex justify-end">
                                <span class="px-4 py-1.5 bg-[#FF6B00] text-white font-bold rounded-full shadow-lg" :style="{ fontSize: hero_data.tag_size + 'px' }" x-text="hero_data.tag"></span>
                            </div>
                            <h2 class="font-black text-white leading-tight" :style="{ fontSize: hero_data.title_size + 'px' }">
                                <span x-text="hero_data.title"></span><br>
                                <span class="text-[#FFB800]" x-text="hero_data.highlight" :style="{ fontSize: hero_data.highlight_size + 'px' }"></span>
                            </h2>
                            <p class="text-white/80 font-medium ml-auto max-w-sm" :style="{ fontSize: hero_data.description_size + 'px' }" x-text="hero_data.desc"></p>
                            
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <div class="px-5 py-3.5 bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl text-white font-bold text-xs flex items-center gap-2">
                                    <template x-if="icon1_preview">
                                        <img :src="icon1_preview" class="w-4 h-4 object-contain">
                                    </template>
                                    <span x-text="hero_data.btn1"></span>
                                </div>
                                <div class="px-6 py-3.5 bg-[#0182C7] text-white rounded-2xl font-bold text-xs flex items-center gap-3 shadow-xl">
                                    <template x-if="icon2_preview">
                                        <img :src="icon2_preview" class="w-4 h-4 object-contain filter invert brightness-0">
                                    </template>
                                    <span x-text="hero_data.btn2"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide Indicators -->
                    <div class="absolute bottom-10 right-12 flex gap-2">
                        <template x-for="(img, index) in bg_previews" :key="index">
                            <div class="h-1.5 rounded-full bg-white transition-all duration-300" :class="current_bg_index === index ? 'w-8' : 'w-2 opacity-50'"></div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
