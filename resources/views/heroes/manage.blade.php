<x-app-layout>
    <div x-data="{ 
        hero_data: {
            tag: '{{ old('tag', $hero->tag ?: 'Exclusive 2026 Offers') }}',
            title: '{{ old('title', $hero->title ?: 'Sri Lanka through') }}',
            highlight: '{{ old('highlighted_title', $hero->highlighted_title ?: 'Arab lensan') }}',
            desc: `{{ old('description', $hero->description ?: 'Luxury trips designed specifically for the Gulf traveler. Enjoy the beauty of nature with complete privacy and royal service.') }}`,
            btn1: '{{ old('btn1_text', $hero->btn1_text ?: 'Free consultation') }}',
            btn2: '{{ old('btn2_text', $hero->btn2_text ?: 'Browse our programs') }}'
        },
        bg_preview: '{{ $hero->background_image ? Storage::url($hero->background_image) : null }}',
        icon1_preview: '{{ $hero->btn1_icon ? Storage::url($hero->btn1_icon) : null }}',
        icon2_preview: '{{ $hero->btn2_icon ? Storage::url($hero->btn2_icon) : null }}',
        isUploading: false,
        
        handleBgChange(e) {
            const file = e.target.files[0];
            if (file) this.bg_preview = URL.createObjectURL(file);
        },
        handleIcon1Change(e) {
            const file = e.target.files[0];
            if (file) this.icon1_preview = URL.createObjectURL(file);
        },
        handleIcon2Change(e) {
            const file = e.target.files[0];
            if (file) this.icon2_preview = URL.createObjectURL(file);
        }
    }" class="space-y-10 animate-in fade-in duration-700 pb-20">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Main Banner Designer</h1>
                <p class="text-slate-400 mt-2 font-semibold">Customize the hero section of your website home page.</p>
            </div>
            <div class="bg-[#0F4A3B]/5 px-6 py-3 rounded-2xl border border-[#0F4A3B]/10">
                <p class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest">Manager Status</p>
                <p class="text-sm font-bold text-slate-600">Single Banner Mode Active</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10 items-start">
            
            <!-- Editor Form -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <form action="{{ route('heroes.store') }}" method="POST" enctype="multipart/form-data" 
                    @submit="isUploading = true"
                    class="space-y-8">
                    @csrf
                    
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Tag / Badge</label>
                            <input type="text" name="tag" x-model="hero_data.tag" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="e.g. Featured Offer">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Main Title (White Text)</label>
                            <input type="text" name="title" x-model="hero_data.title" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Sri Lanka through">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Highlighted Title (Gold Text)</label>
                            <input type="text" name="highlighted_title" x-model="hero_data.highlight" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Arab lensan">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Background Image (10MB Max)</label>
                            <div class="relative">
                                <input type="file" name="background_image" @change="handleBgChange" class="w-full px-6 py-3.5 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-400 cursor-pointer overflow-hidden">
                                @if($hero->background_image)
                                    <p class="text-[10px] text-emerald-600 font-bold mt-1 px-1">Current: {{ basename($hero->background_image) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description</label>
                        <textarea name="description" x-model="hero_data.desc" rows="3" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Luxury trips designed specifically for..."></textarea>
                    </div>

                    <!-- Buttons Config -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-slate-50 pt-8">
                        <!-- Button 1 -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-black text-[#0F4A3B] uppercase tracking-widest">Button 1 (Left)</h4>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Button Name</label>
                                <input type="text" name="btn1_text" x-model="hero_data.btn1" class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Target URL</label>
                                <input type="text" name="btn1_url" value="{{ old('btn1_url', $hero->btn1_url) }}" class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none" placeholder="https://...">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Icon (PNG)</label>
                                <input type="file" name="btn1_icon" @change="handleIcon1Change" class="w-full text-xs font-bold text-slate-400">
                            </div>
                        </div>

                        <!-- Button 2 -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-black text-[#0F4A3B] uppercase tracking-widest">Button 2 (Right)</h4>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Button Name</label>
                                <input type="text" name="btn2_text" x-model="hero_data.btn2" class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Target URL</label>
                                <input type="text" name="btn2_url" value="{{ old('btn2_url', $hero->btn2_url) }}" class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none" placeholder="https://...">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Icon (PNG)</label>
                                <input type="file" name="btn2_icon" @change="handleIcon2Change" class="w-full text-xs font-bold text-slate-400">
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div x-show="isUploading" class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <span class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest">Uploading Assets...</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden shadow-inner">
                            <div class="bg-[#0F4A3B] h-full shadow-lg transition-all duration-300 animate-[progress_2s_ease-in-out_infinite]" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-6">
                        <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-[1.5rem] font-black text-lg shadow-2xl shadow-[#0F4A3B]/20 hover:opacity-95 transition-all">
                            Save Design Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Live Preview -->
            <div class="sticky top-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Home Page Preview
                </p>
                
                <div class="relative aspect-video rounded-[3.5rem] overflow-hidden shadow-2xl border-4 border-white">
                    <!-- Background -->
                    <div class="absolute inset-0 bg-slate-900">
                        <template x-if="bg_preview">
                            <img :src="bg_preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!bg_preview">
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0F4A3B] to-slate-900 opacity-50">
                                <p class="text-white text-xs font-bold opacity-30">Background Image Placeholder</p>
                            </div>
                        </template>
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>

                    <!-- Content -->
                    <div class="relative h-full flex items-center justify-end px-12 text-right">
                        <div class="max-w-xl space-y-6">
                            <div class="flex justify-end">
                                <span class="px-4 py-1.5 bg-[#FF6B00] text-white text-[10px] font-bold rounded-full shadow-lg" x-text="hero_data.tag"></span>
                            </div>
                            
                            <h2 class="text-5xl font-black text-white leading-[1.1]">
                                <span x-text="hero_data.title"></span><br>
                                <span class="text-[#FFB800]" x-text="hero_data.highlight"></span>
                            </h2>
                            
                            <p class="text-white/80 font-medium text-base ml-auto max-w-sm" x-text="hero_data.desc"></p>

                            <div class="flex items-center justify-end gap-4 pt-4">
                                <div class="px-6 py-4 bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl text-white font-bold text-sm flex items-center gap-2 cursor-pointer transition-all">
                                    <template x-if="icon1_preview">
                                        <img :src="icon1_preview" class="w-5 h-5 object-contain">
                                    </template>
                                    <span x-text="hero_data.btn1"></span>
                                </div>
                                <div class="px-8 py-4 bg-[#0182C7] text-white rounded-2xl font-bold text-sm flex items-center gap-3 shadow-xl cursor-pointer transition-all">
                                    <template x-if="icon2_preview">
                                        <img :src="icon2_preview" class="w-5 h-5 object-contain filter invert brightness-0">
                                    </template>
                                    <span x-text="hero_data.btn2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-[#0F4A3B]/5 border border-[#0F4A3B]/10 rounded-[2rem] p-6">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-white rounded-xl shadow-sm">
                            <svg class="w-6 h-6 text-[#0F4A3B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Administrative Helper</p>
                            <p class="text-sm font-bold text-slate-400 mt-1">Changes saved here are instantly visible to visitors. Recommended image size: 1920x1080px.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes progress { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
    </style>
</x-app-layout>
