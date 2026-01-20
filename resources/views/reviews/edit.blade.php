<x-app-layout>
    <div x-data="reviewEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('reviews.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit Review</h1>
                <p class="text-slate-400 mt-2 font-semibold">Modify review details and images.</p>
            </div>
        </div>

        <form action="{{ route('reviews.update', $review) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            @method('PUT')

            <!-- Left Col: Basics -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">User Name</label>
                            <input type="text" name="user_name" required value="{{ old('user_name', $review->user_name) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Review Date</label>
                            <input type="date" name="date" required value="{{ old('date', $review->date->format('Y-m-d')) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Rating</label>
                            <select name="rating" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                @foreach([5,4,3,2,1] as $star)
                                    <option value="{{ $star }}" {{ old('rating', $review->rating) == $star ? 'selected' : '' }}>{{ $star }} Stars</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Review Source</label>
                            <select name="source" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                @foreach(['Tripadvisor', 'Google', 'Facebook', 'Instagram', 'Website', 'Others'] as $src)
                                    <option value="{{ $src }}" {{ old('source', $review->source) == $src ? 'selected' : '' }}>{{ $src }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">User Location</label>
                            <input type="text" name="user_location" value="{{ old('user_location', $review->user_location) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Added By</label>
                            <input type="text" name="added_by" value="{{ old('added_by', $review->added_by) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description / Comment</label>
                        <textarea name="description" required rows="5" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">{{ old('description', $review->description) }}</textarea>
                    </div>

                    <!-- Multiple Image Gallery -->
                    <div class="pt-6 border-t border-slate-50 space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Review Gallery (New uploads will replace existing)</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            <!-- Existing Images -->
                            @if($review->images)
                                @foreach($review->images as $img)
                                    <div class="relative aspect-square rounded-2xl overflow-hidden border border-slate-100 shadow-sm opacity-50">
                                        <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover grayscale">
                                        <div class="absolute inset-0 flex items-center justify-center bg-slate-900/10">
                                            <span class="text-[8px] font-black text-white uppercase tracking-widest bg-[#0F4A3B] px-2 py-0.5 rounded shadow-sm">Current</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <!-- Previews for new files -->
                            <template x-for="(preview, index) in galleryPreviews" :key="index">
                                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border-2 border-[#0F4A3B]/20 group">
                                    <img :src="preview" class="w-full h-full object-cover">
                                    <button type="button" @click="removeGalleryItem(index)" class="absolute top-2 right-2 p-1 bg-white/80 backdrop-blur rounded-lg text-rose-500 opacity-0 group-hover:opacity-100 transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </template>
                            
                            <label class="relative aspect-square rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-300 hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 hover:bg-[#0F4A3B]/5 transition-all cursor-pointer">
                                <input type="file" name="images[]" multiple class="hidden" @change="previewGallery($event)">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                <span class="text-[9px] font-black uppercase mt-1">Replace All</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: User Image & Status -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">User Profile Image</label>
                        <div class="relative aspect-square w-32 mx-auto bg-slate-50 rounded-full border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="user_image" @change="previewUser($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <img :src="userPreview || '{{ $review->user_image ? Storage::url($review->user_image) : 'https://ui-avatars.com/api/?name='.urlencode($review->user_name) }}'" class="w-full h-full object-cover">
                        </div>
                        <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">Update Photo</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Display Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active" {{ $review->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $review->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Update Review
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function reviewEditor() {
            return {
                userPreview: null,
                galleryPreviews: [],
                
                previewUser(e) {
                    const file = e.target.files[0];
                    if (file) this.userPreview = URL.createObjectURL(file);
                },

                previewGallery(e) {
                    const files = Array.from(e.target.files);
                    files.forEach(file => {
                        this.galleryPreviews.push(URL.createObjectURL(file));
                    });
                },

                removeGalleryItem(index) {
                    this.galleryPreviews.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>
