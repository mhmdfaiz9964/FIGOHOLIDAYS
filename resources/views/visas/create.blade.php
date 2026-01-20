<x-app-layout>
    <div x-data="visaEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('visas.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Create Visa Page</h1>
                <p class="text-slate-400 mt-2 font-semibold">Define content for new visa entry.</p>
            </div>
        </div>

        <form action="{{ route('visas.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf

            <!-- Left Col: Content -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Main Title</label>
                            <input type="text" name="title" required value="{{ old('title') }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Update Section Title (Subtitle)</label>
                            <input type="text" name="update_title" value="{{ old('update_title') }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Official Website URL</label>
                            <input type="url" name="website_url" value="{{ old('website_url') }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description / Requirements</label>
                        <div class="ck-editor-container">
                            <textarea id="editor" name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Images -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Hero Background Image</label>
                        <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="background_image" @change="previewBg($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <template x-if="bgPreview">
                                <img :src="bgPreview" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!bgPreview" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Background Image</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Content Image</label>
                        <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="image" @change="previewMain($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <template x-if="mainPreview">
                                <img :src="mainPreview" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!mainPreview" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Main Image</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Save Visa Page
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        }).catch(error => console.error(error));

        function visaEditor() {
            return {
                bgPreview: null,
                mainPreview: null,
                previewBg(e) {
                    const file = e.target.files[0];
                    if (file) this.bgPreview = URL.createObjectURL(file);
                },
                previewMain(e) {
                    const file = e.target.files[0];
                    if (file) this.mainPreview = URL.createObjectURL(file);
                }
            }
        }
    </script>
</x-app-layout>
