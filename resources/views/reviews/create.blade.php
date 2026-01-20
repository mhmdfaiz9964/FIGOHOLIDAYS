<x-app-layout>
    <div x-data="reviewEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('reviews.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Add Review</h1>
                <p class="text-slate-400 mt-2 font-semibold">Post a new customer testimonial or social review.</p>
            </div>
        </div>

        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf

            <!-- Left Col: Basics -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- User Info -->
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">User Name</label>
                            <input type="text" name="user_name" required value="{{ old('user_name') }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="John Doe">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Review Date</label>
                            <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>

                        <!-- Rating & Source -->
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Rating</label>
                            <select name="rating" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                @foreach([5,4,3,2,1] as $star)
                                    <option value="{{ $star }}" {{ old('rating') == $star ? 'selected' : '' }}>{{ $star }} Stars</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Review Source</label>
                            <select name="source" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                @foreach(['Tripadvisor', 'Google', 'Facebook', 'Instagram', 'Website', 'Others'] as $src)
                                    <option value="{{ $src }}" {{ old('source') == $src ? 'selected' : '' }}>{{ $src }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location & Added By -->
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">User Location</label>
                            <input type="text" name="user_location" value="{{ old('user_location') }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="e.g. London, UK">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Added By</label>
                            <input type="text" name="added_by" value="{{ old('added_by', Auth::user()->name ?? '') }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description / Comment</label>
                        <textarea name="description" required rows="5" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="What did the customer say?">{{ old('description') }}</textarea>
                    </div>

                    <!-- Multiple Gallery Images -->
                    <div class="pt-6 border-t border-slate-50 space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Review Gallery (Multiple)</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            <template x-for="(preview, index) in galleryPreviews" :key="index">
                                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border border-slate-100 group">
                                    <img :src="preview" class="w-full h-full object-cover">
                                    <button type="button" @click="removeGalleryItem(index)" class="absolute top-2 right-2 p-1 bg-white/80 backdrop-blur rounded-lg text-rose-500 opacity-0 group-hover:opacity-100 transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </template>
                            <label class="relative aspect-square rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-300 hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 hover:bg-[#0F4A3B]/5 transition-all cursor-pointer">
                                <input type="file" name="images[]" multiple class="hidden" @change="previewGallery($event)">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                <span class="text-[9px] font-black uppercase mt-1">Add Images</span>
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
                            <template x-if="userPreview">
                                <img :src="userPreview" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!userPreview" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                        </div>
                        <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">Customer Photo</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Display Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Save Review
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
