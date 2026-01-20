<x-app-layout>
    <div x-data="visaPreviewer()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Visa Page Settings</h1>
                <p class="text-slate-400 mt-2 font-semibold">Manage the content and look of your Sri Lanka visa guide.</p>
            </div>
            <button @click="showPreview = !showPreview" class="px-6 py-3 bg-white border border-slate-100 rounded-2xl font-bold text-sm text-[#0F4A3B] shadow-sm hover:shadow-md transition-all">
                <span x-text="showPreview ? 'Hide Live Preview' : 'Show Live Preview'"></span>
            </button>
        </div>

        <div class="grid grid-cols-1 gap-10" :class="showPreview ? 'xl:grid-cols-2' : ''">
            <!-- Form Section -->
            <form action="{{ route('visas.update', $visa) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Main Hero Title</label>
                            <input type="text" name="title" x-model="content.title" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Update Section Title (Subtitle)</label>
                            <input type="text" name="update_title" x-model="content.update_title" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Official Website URL</label>
                            <input type="url" name="website_url" x-model="content.website_url" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description / Requirements</label>
                        <div class="ck-editor-container">
                            <textarea id="editor" name="description">{{ $visa->description }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Hero Background Image</label>
                            <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                                <input type="file" name="background_image" @change="previewBg($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <img :src="bgPreviewUrl || '{{ $visa->background_image ? Storage::url($visa->background_image) : '' }}'" class="w-full h-full object-cover {{ !$visa->background_image ? 'hidden' : '' }}" :class="bgPreviewUrl || '{{ $visa->background_image }}' ? '' : 'hidden'">
                                <div x-show="!bgPreviewUrl && !'{{ $visa->background_image }}'" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Side Card Image</label>
                            <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                                <input type="file" name="image" @change="previewMain($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <img :src="mainPreviewUrl || '{{ $visa->image ? Storage::url($visa->image) : '' }}'" class="w-full h-full object-cover {{ !$visa->image ? 'hidden' : '' }}" :class="mainPreviewUrl || '{{ $visa->image }}' ? '' : 'hidden'">
                                <div x-show="!mainPreviewUrl && !'{{ $visa->image }}'" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.01] active:scale-95 transition-all mt-4">
                        Update Visa Page
                    </button>
                </div>
            </form>

            <!-- Preview Section -->
            <div x-show="showPreview" x-cloak class="sticky top-10 space-y-6 animate-in slide-in-from-right-10 duration-500">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl overflow-hidden h-[800px] overflow-y-auto">
                    <!-- Hero Preview -->
                    <div class="relative h-64 flex flex-col items-center justify-center text-center px-10">
                        <img :src="bgPreviewUrl || '{{ $visa->background_image ? Storage::url($visa->background_image) : 'https://placehold.co/1200x600' }}'" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40"></div>
                        <div class="relative z-10">
                            <h2 class="text-3xl font-black text-white" x-text="content.title"></h2>
                            <p class="text-white/80 text-xs font-bold mt-2">Your complete guide to obtaining travel permits.</p>
                        </div>
                    </div>

                    <!-- Layout Content -->
                    <div class="p-10 space-y-10">
                        <!-- Alert Box -->
                        <div class="bg-white rounded-3xl border border-orange-100 shadow-sm p-6 relative overflow-hidden">
                            <div class="absolute right-0 top-0 bottom-0 w-1 bg-orange-500"></div>
                            <h3 class="text-orange-600 font-extrabold text-sm text-right" x-text="content.update_title"></h3>
                            <div class="text-[10px] font-bold text-slate-500 text-right mt-2 prose prose-sm max-w-none" x-html="content.description"></div>
                        </div>

                        <!-- Requirements Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                             <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="p-2 bg-slate-100 rounded-lg"><svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg></span>
                                    <h4 class="font-black text-slate-800 text-sm">Basic Requirements</h4>
                                </div>
                                <div class="space-y-2">
                                    <div class="p-4 bg-slate-50 rounded-xl text-[10px] font-black text-slate-500 border border-slate-100/50 flex items-center justify-between">
                                        Passport valid for at least 6 months
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" /></svg>
                                    </div>
                                    <div class="p-4 bg-slate-50 rounded-xl text-[10px] font-black text-slate-500 border border-slate-100/50 flex items-center justify-between">
                                        Confirmed return flight ticket
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" /></svg>
                                    </div>
                                </div>
                             </div>

                             <div class="bg-indigo-950 rounded-3xl p-8 relative overflow-hidden group">
                                <img :src="mainPreviewUrl || '{{ $visa->image ? Storage::url($visa->image) : 'https://placehold.co/600x400' }}'" class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-110 transition-transform duration-700">
                                <div class="relative z-10 text-right">
                                    <h4 class="text-white font-black text-xl mb-4">Make sure you are ready</h4>
                                    <p class="text-white/70 text-[10px] leading-relaxed">We are here to ensure a legally hassle-free journey to the pearl of the Indian Ocean.</p>
                                </div>
                             </div>
                        </div>

                        <!-- Link -->
                        <div class="text-center pt-10">
                            <a :href="content.website_url" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 font-extrabold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                Official website link (ETA)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        function visaPreviewer() {
            return {
                showPreview: true,
                bgPreviewUrl: null,
                mainPreviewUrl: null,
                content: {
                    title: '{{ $visa->title }}',
                    update_title: '{{ $visa->update_title }}',
                    description: `{!! $visa->description !!}`,
                    website_url: '{{ $visa->website_url }}'
                },

                init() {
                    ClassicEditor.create(document.querySelector('#editor'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
                    }).then(editor => {
                        editor.model.document.on('change:data', () => {
                            this.content.description = editor.getData();
                        });
                    }).catch(error => console.error(error));
                },

                previewBg(e) {
                    const file = e.target.files[0];
                    if (file) this.bgPreviewUrl = URL.createObjectURL(file);
                },
                previewMain(e) {
                    const file = e.target.files[0];
                    if (file) this.mainPreviewUrl = URL.createObjectURL(file);
                }
            }
        }
    </script>
</x-app-layout>
