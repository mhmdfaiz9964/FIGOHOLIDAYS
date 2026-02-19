<x-app-layout>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <div x-data="offerManager()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('offers.index') }}"
                class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit Master Offer</h1>
                <p class="text-slate-400 mt-2 font-semibold">Update details for {{ $offer->title }}.</p>
            </div>
        </div>

        <form action="{{ route('offers.update', $offer) }}" method="POST" enctype="multipart/form-data"
            @submit="isUploading = true" class="space-y-12">
            @csrf
            @method('PUT')

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <div class="flex items-center gap-4 border-b border-slate-50 pb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#0F4A3B]/5 flex items-center justify-center text-[#0F4A3B]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Basic Information</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Core details and
                            primary pricing</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="space-y-2 lg:col-span-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Offer
                            Title</label>
                        <input type="text" name="title" value="{{ $offer->title }}" required
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Status</label>
                        <select name="status"
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active" {{ $offer->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $offer->status == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Offer
                            Category</label>
                        <select name="offer_category_id" required
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $offer->offer_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-1">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Offer Type
                                (Primary)</label>
                            <button type="button" @click="showTypeModal = true"
                                class="text-[#0F4A3B] hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative">
                            <select name="offer_type_id" required
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                <option value="">Select Primary Type</option>
                                <template x-for="type in allTypes" :key="type.id">
                                    <option :value="type.id" :selected="type.id == {{ $offer->offer_type_id }}"
                                        x-text="type.name"></option>
                                </template>
                            </select>
                            <div
                                class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Price
                            ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ $offer->price }}" required
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Offer Price
                            ($)</label>
                        <input type="number" step="0.01" name="offer_price" value="{{ $offer->offer_price }}"
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Duration
                            (Days)</label>
                        <input type="number" name="days" value="{{ $offer->days }}" required
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Duration
                            (Nights)</label>
                        <input type="number" name="nights" value="{{ $offer->nights }}" required
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-1">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Rating
                                Label</label>
                            <button type="button" @click.prevent="showRatingModal = true"
                                class="text-[#0F4A3B] hover:scale-110 transition-transform cursor-pointer p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <select name="rating_id"
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="">Select Rating (Optional)</option>
                            <template x-for="rating in allRatings" :key="rating.id">
                                <option :value="rating.id" :selected="rating.id == selectedRatingId"
                                    x-text="rating.name"></option>
                            </template>
                        </select>
                        <input type="hidden" name="star_rating" value="">
                    </div>
                </div>

                <!-- Offer Types -->
                <div class="space-y-4 pt-6">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Select Offer
                            Types (Multiple)</label>
                        <button type="button" @click="showTypeModal = true"
                            class="flex items-center gap-2 text-[#0F4A3B] font-bold text-xs hover:opacity-70 transition-all">
                            <span
                                class="w-6 h-6 rounded-lg bg-[#0F4A3B]/10 flex items-center justify-center font-black text-base">+</span>
                            Create New Type
                        </button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <template x-for="type in allTypes" :key="type.id">
                            <label class="relative cursor-pointer group">
                                <input type="checkbox" name="types[]" :value="type.id"
                                    :checked="selectedTypeIds.includes(type.id)" class="peer hidden">
                                <div
                                    class="px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-center transition-all peer-checked:bg-[#0F4A3B]/5 peer-checked:border-[#0F4A3B]/20 peer-checked:text-[#0F4A3B] group-hover:bg-slate-100">
                                    <span class="text-xs font-black uppercase tracking-widest"
                                        x-text="type.name"></span>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>

                <div class="space-y-2 pt-4">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Meta Description
                        (SEO)</label>
                    <textarea name="meta_description" rows="3"
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">{{ $offer->meta_description }}</textarea>
                </div>
            </div>

            <!-- Section 2: Highlights & Policies -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <div class="flex items-center gap-4 border-b border-slate-50 pb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#0F4A3B]/5 flex items-center justify-center text-[#0F4A3B]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Highlights & Policies</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Inclusions,
                            Exclusions, and Terms</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label
                                class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Inclusions</label>
                            <button type="button" @click="addInclusion()"
                                class="text-[10px] font-black text-[#0F4A3B] uppercase">+ Add</button>
                        </div>
                        <template x-for="(inc, i) in inclusions" :key="i">
                            <div class="flex gap-2">
                                <input type="text" name="inclusions[]" x-model="inclusions[i]"
                                    class="flex-1 px-4 py-2 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                                <button type="button" @click="removeInclusion(i)" class="text-rose-400">&times;</button>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label
                                class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Exclusions</label>
                            <button type="button" @click="addExclusion()"
                                class="text-[10px] font-black text-[#0F4A3B] uppercase">+ Add</button>
                        </div>
                        <template x-for="(exc, i) in exclusions" :key="i">
                            <div class="flex gap-2">
                                <input type="text" name="exclusions[]" x-model="exclusions[i]"
                                    class="flex-1 px-4 py-2 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                                <button type="button" @click="removeExclusion(i)" class="text-rose-400">&times;</button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">More Details /
                            Description</label>
                        <textarea name="more_details" id="more_details"
                            class="ckeditor">{{ $offer->more_details }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Cancellation
                            Policy</label>
                        <textarea name="cancellation_policy" id="cancellation_policy"
                            class="ckeditor">{{ $offer->cancellation_policy }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 2: Media Assets -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <div class="flex items-center gap-4 border-b border-slate-50 pb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#0F4A3B]/5 flex items-center justify-center text-[#0F4A3B]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Media Assets</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Leave blank to keep
                            existing files</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Thumbnail -->
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Main
                            Thumbnail</label>
                        <div
                            class="relative group aspect-video rounded-3xl overflow-hidden bg-slate-50 border-2 border-dashed border-slate-200">
                            <input type="file" name="thumbnail_image" @change="previewMedia($event, 'thumb')"
                                class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <img :src="previews.thumb || '{{ Storage::url($offer->thumbnail_image) }}'"
                                class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Video -->
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Promotional
                            Video</label>
                        <div
                            class="relative group aspect-video rounded-3xl overflow-hidden bg-slate-50 border-2 border-dashed border-slate-200">
                            <input type="file" name="video" @change="previewMedia($event, 'video')"
                                class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p class="text-[10px] font-black text-slate-300 uppercase mt-2"
                                    x-text="previews.video_name || 'Change Video'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Gallery Images
                            (Multiple)</label>
                        <div
                            class="relative group aspect-video rounded-3xl overflow-hidden bg-slate-50 border-2 border-dashed border-slate-200">
                            <input type="file" name="gallery_images[]" multiple
                                @change="previewMedia($event, 'gallery')"
                                class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <p class="text-[10px] font-black text-slate-300 uppercase"
                                    x-text="previews.gallery_count ? previews.gallery_count + ' Images Selected' : 'Replace {{ count($offer->gallery_images ?? []) }} Images'">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Sidebar Banner -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <div class="flex items-center gap-4 border-b border-slate-50 pb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#0F4A3B]/5 flex items-center justify-center text-[#0F4A3B]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Sidebar Call-to-Action Banner</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Special banner for
                            detail page</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase">Banner Label</label>
                                <input type="text" name="sidebar_banner_label"
                                    value="{{ $offer->sidebar_banner_label }}"
                                    class="w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase">Banner Title</label>
                                <input type="text" name="sidebar_banner_title"
                                    value="{{ $offer->sidebar_banner_title }}"
                                    class="w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Description</label>
                            <textarea name="sidebar_banner_description" rows="2"
                                class="w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">{{ $offer->sidebar_banner_description }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase">Target URL</label>
                                <input type="text" name="sidebar_banner_url" value="{{ $offer->sidebar_banner_url }}"
                                    class="w-full px-5 py-3 bg-slate-50 border-transparent rounded-xl font-bold text-sm outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase">Background Image</label>
                                <input type="file" name="sidebar_banner_image"
                                    class="w-full text-xs font-bold text-slate-400">
                            </div>
                        </div>
                    </div>
                    @if($offer->sidebar_banner_image)
                        <div class="rounded-3xl overflow-hidden shadow-xl">
                            <img src="{{ Storage::url($offer->sidebar_banner_image) }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 4: Detailed Itinerary -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-10">
                <div class="flex items-center justify-between border-b border-slate-50 pb-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-[#0F4A3B]/5 flex items-center justify-center text-[#0F4A3B]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Custom Itinerary</h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Day-by-day
                                activities</p>
                        </div>
                    </div>
                    <button type="button" @click="addDay()"
                        class="px-6 py-3 bg-[#0F4A3B] text-white rounded-xl font-black text-xs hover:scale-105 transition-all">
                        + Add Day Plan
                    </button>
                </div>

                <div class="space-y-12">
                    <template x-for="(day, index) in itineraries" :key="day.temp_id">
                        <div
                            class="relative bg-slate-50/50 rounded-[2rem] p-8 border border-slate-100 animate-in slide-in-from-top-4 duration-500">
                            <button type="button" @click="removeDay(index)"
                                class="absolute top-6 right-6 w-10 h-10 bg-white shadow-sm border border-rose-50 rounded-xl flex items-center justify-center text-rose-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                                <div class="lg:col-span-1 space-y-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Day Label</label>
                                        <input type="hidden" :name="'itineraries['+index+'][id]'" :value="day.id">
                                        <input type="text" :name="'itineraries['+index+'][day]'" x-model="day.day"
                                            class="w-full px-5 py-3 bg-white rounded-xl font-black text-[#0F4A3B] outline-none">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Replace Day
                                            Images</label>
                                        <div
                                            class="relative h-24 bg-white border-2 border-dashed border-slate-100 rounded-xl flex items-center justify-center text-slate-300">
                                            <input type="file" :name="'itineraries['+index+'][images][]'" multiple
                                                class="absolute inset-0 opacity-0 cursor-pointer">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>
                                        <template x-if="day.images && day.images.length">
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <template x-for="(img, imgIdx) in day.images" :key="imgIdx">
                                                    <div
                                                        class="w-10 h-10 rounded-lg overflow-hidden border border-slate-100 shadow-sm">
                                                        <img :src="'/storage/'+img" class="w-full h-full object-cover">
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="lg:col-span-3 space-y-6">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Daily Content
                                            Title</label>
                                        <input type="text" :name="'itineraries['+index+'][title]'" x-model="day.title"
                                            class="w-full px-5 py-3 bg-white rounded-xl font-bold text-slate-900 outline-none">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-slate-400 uppercase">Description</label>
                                        <textarea :name="'itineraries['+index+'][description]'"
                                            x-model="day.description" rows="3"
                                            class="w-full px-5 py-3 bg-white rounded-xl font-medium text-slate-600 outline-none text-sm ckeditor-it"></textarea>
                                    </div>

                                    <!-- Activities -->
                                    <div class="space-y-4 pt-4">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest">
                                                Key Activities</h4>
                                            <button type="button" @click="addActivity(index)"
                                                class="text-[10px] font-black text-[#0F4A3B] uppercase cursor-pointer hover:underline">+
                                                Add Activity</button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <template x-for="(act, actIndex) in day.activities" :key="act.temp_id">
                                                <div
                                                    class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm border border-white">
                                                    <div
                                                        class="flex-shrink-0 relative w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center overflow-hidden border border-slate-100">
                                                        <input type="hidden"
                                                            :name="'itineraries['+index+'][activities]['+actIndex+'][old_icon]'"
                                                            :value="act.icon">
                                                        <input type="file"
                                                            :name="'itineraries['+index+'][activities]['+actIndex+'][icon]'"
                                                            class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                                            @change="previewActIcon($event, index, actIndex)">
                                                        <template x-if="act.preview_icon || act.icon">
                                                            <img :src="act.preview_icon || '/storage/'+act.icon"
                                                                class="w-full h-full object-cover">
                                                        </template>
                                                        <template x-if="!act.preview_icon && !act.icon">
                                                            <svg class="w-4 h-4 text-slate-300" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </template>
                                                    </div>
                                                    <input type="text"
                                                        :name="'itineraries['+index+'][activities]['+actIndex+'][text]'"
                                                        x-model="act.text"
                                                        class="flex-1 bg-transparent text-xs font-bold border-none outline-none ring-0 focus:ring-0">
                                                    <button type="button" @click="removeActivity(index, actIndex)"
                                                        class="text-rose-400 p-1">&times;</button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-10 left-0 right-0 z-50 px-10">
                <div
                    class="bg-white/80 backdrop-blur-xl border border-white p-6 rounded-[2.5rem] shadow-2xl flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Master Edit
                            Mode</span>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-3 h-3 rounded-full bg-amber-500 animate-pulse"></div>
                            <span class="text-sm font-black text-slate-900">Synchronizing All Media</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('offers.index') }}"
                            class="px-8 py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold hover:bg-slate-200 transition-all text-sm">Discard</a>
                        <button type="submit"
                            class="px-12 py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-105 active:scale-95 transition-all text-sm">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Offer Type Modal -->
        <div x-show="showTypeModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showTypeModal = false" class="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl">
                <h3 class="text-2xl font-black text-slate-900">Create New Type</h3>
                <div class="mt-8 space-y-6">
                    <input type="text" x-model="newTypeName" placeholder="e.g. Wedding Package"
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none">
                    <div class="flex flex-col gap-3">
                        <button type="button" @click="saveNewType()" :disabled="!newTypeName"
                            class="w-full py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-lg">Save
                            Type</button>
                        <button type="button" @click="showTypeModal = false"
                            class="w-full py-4 bg-slate-50 text-slate-400 rounded-2xl font-bold">Cancel</button>
                    </div>
                </div>
            </div>

            <!-- Rating Modal -->
            <div x-show="showRatingModal" style="display: none;" x-transition
                class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm">
                <div @click.away="showRatingModal = false"
                    class="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl">
                    <h3 class="text-2xl font-black text-slate-900">Create New Rating</h3>
                    <p class="text-slate-400 text-sm font-bold mt-2">Example: 5 Stars, Excellent, etc.</p>
                    <div class="mt-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Label Name</label>
                            <input type="text" x-model="newRatingName" placeholder="e.g. Excellent"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none focus:bg-white focus:border-[#0F4A3B]/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Score Value
                                (Optional)</label>
                            <input type="text" x-model="newRatingValue" placeholder="e.g. 5.0"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 outline-none focus:bg-white focus:border-[#0F4A3B]/20 transition-all">
                        </div>
                        <div class="flex flex-col gap-3">
                            <button type="button" @click="saveNewRating()" :disabled="!newRatingName"
                                class="w-full py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-lg">Save
                                Rating</button>
                            <button type="button" @click="showRatingModal = false"
                                class="w-full py-4 bg-slate-50 text-slate-400 rounded-2xl font-bold">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function offerManager() {
                return {
                    showTypeModal: false,
                    showRatingModal: false,
                    isUploading: false,
                    newTypeName: '',
                    newRatingName: '',
                    newRatingValue: '',
                    allTypes: {!! $types->toJson() !!},
                    allRatings: {!! $ratings->toJson() !!},
                    selectedTypeIds: {!! $offer->types->pluck('id')->toJson() !!},
                    selectedRatingId: {{ $offer->rating_id ?? 'null' }},
                    inclusions: {!! json_encode($offer->inclusions ?? []) !!},
                    exclusions: {!! json_encode($offer->exclusions ?? []) !!},
                    previews: { thumb: null, video_name: null, gallery_count: 0 },
                    itineraries: {!! $offer->itineraries->map(function ($it) {
    $it->temp_id = $it->id;
    if ($it->activities) {
        $it->activities = collect($it->activities)->map(function ($act, $idx) {
            $act['temp_id'] = $idx;
            $act['preview_icon'] = null;
            return $act;
        })->toArray();
    }
    return $it;
})->toJson() !!},

                    previewMedia(e, type) {
                        const files = e.target.files;
                        if (!files[0]) return;
                        if (type === 'thumb') this.previews.thumb = URL.createObjectURL(files[0]);
                        else if (type === 'video') this.previews.video_name = files[0].name;
                        else if (type === 'gallery') this.previews.gallery_count = files.length;
                    },

                    addDay() {
                        this.itineraries.push({ temp_id: Date.now(), day: 'Day ' + (this.itineraries.length + 1), title: '', description: '', activities: [{ temp_id: Date.now() + 1, text: '' }] });
                    },

                    removeDay(index) { this.itineraries.splice(index, 1); },

                    addActivity(dayIndex) { this.itineraries[dayIndex].activities.push({ temp_id: Date.now(), text: '', icon: null, preview_icon: null }); },

                    removeActivity(dayIndex, actIndex) { this.itineraries[dayIndex].activities.splice(actIndex, 1); },

                    addInclusion() { this.inclusions.push(''); },
                    removeInclusion(i) { this.inclusions.splice(i, 1); },

                    addExclusion() { this.exclusions.push(''); },
                    removeExclusion(i) { this.exclusions.splice(i, 1); },

                    previewActIcon(e, dayIdx, actIdx) {
                        const file = e.target.files[0];
                        if (file) this.itineraries[dayIdx].activities[actIdx].preview_icon = URL.createObjectURL(file);
                    },

                    saveNewType() {
                        fetch('{{ route("offer-types.store") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ name: this.newTypeName })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    this.allTypes.push(data.data);
                                    this.newTypeName = '';
                                    this.showTypeModal = false;
                                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'New type added!', showConfirmButton: false, timer: 2000 });
                                }
                            });
                    },

                    saveNewRating() {
                        fetch('{{ route("ratings.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: this.newRatingName, value: this.newRatingValue })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    this.allRatings.push(data.data);
                                    this.newRatingName = '';
                                    this.newRatingValue = '';
                                    this.showRatingModal = false;

                                    Swal.fire({
                                        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                                        icon: 'success', title: 'Rating label created!'
                                    });
                                }
                            });
                    }
                }
            }

            // Initialize CKEditor
            window.onload = function () {
                CKEDITOR.replaceAll('ckeditor');

                // For dynamic itinerary descriptions, we might need a observer or just regular textareas if they are too many
                // But CKEditor standard replaceAll works for existing ones. 
                // For dynamic ones added via Alpine, we might need to stick to standard textareas or a different approach.
                // I'll keep it simple for now as requested.
            }
        </script>
</x-app-layout>