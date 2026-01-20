<x-app-layout>
    <div x-data="restaurantEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('restaurants.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Add Restaurant</h1>
                <p class="text-slate-400 mt-2 font-semibold">Define restaurant details, location, and cuisine.</p>
            </div>
        </div>

        <form action="{{ route('restaurants.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf

            <!-- Left Col: Basics -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Restaurant Name</label>
                            <input type="text" name="name" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all @error('name') border-rose-500 @enderror" placeholder="e.g. The Ocean Breeze" value="{{ old('name') }}">
                            @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Cuisine Type</label>
                            <input type="text" name="type" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all @error('type') border-rose-500 @enderror" placeholder="e.g. Fine Dining, Seafood" value="{{ old('type') }}">
                            @error('type') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Rating</label>
                            <select name="rating" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                @foreach([5,4,3,2,1] as $star)
                                    <option value="{{ $star }}" {{ old('rating', 5) == $star ? 'selected' : '' }}>{{ $star }} Stars</option>
                                @endforeach
                            </select>
                            @error('rating') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Google Maps URL</label>
                            <input type="url" name="map_url" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all @error('map_url') border-rose-500 @enderror" placeholder="https://maps.google.com/..." value="{{ old('map_url') }}">
                            @error('map_url') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description</label>
                        <div class="ck-editor-container">
                            <textarea id="editor" name="description">{{ old('description') }}</textarea>
                        </div>
                        @error('description') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Right Col: Image & Status -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Restaurant Image</label>
                        <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="image" @change="previewMedia($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!preview" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Upload Image</p>
                            </div>
                        </div>
                        @error('image') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Visibility Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-[10px] font-bold mt-1 px-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Save Restaurant
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });

        function restaurantEditor() {
            return {
                preview: null,
                previewMedia(e) {
                    const file = e.target.files[0];
                    if (file) this.preview = URL.createObjectURL(file);
                }
            }
        }
    </script>
    <style>
        .ck-editor__editable { min-height: 250px; border-radius: 0 0 1.5rem 1.5rem !important; border-color: #f1f5f9 !important; padding: 0 2rem !important; }
        .ck-toolbar { border-radius: 1.5rem 1.5rem 0 0 !important; border-color: #f1f5f9 !important; padding: 10px !important; }
        .ck-editor__editable_focused { box-shadow: none !important; border-color: #0F4A3B33 !important; }
    </style>
</x-app-layout>
