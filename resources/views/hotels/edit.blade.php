<x-app-layout>
    <div x-data="hotelEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('hotels.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit Hotel</h1>
                <p class="text-slate-400 mt-2 font-semibold">Update hotel information and pricing.</p>
            </div>
        </div>

        <form action="{{ route('hotels.update', $hotel) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            @method('PUT')

            <!-- Left Col: Details -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Hotel Name</label>
                            <input type="text" name="name" required value="{{ old('name', $hotel->name) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Location Address</label>
                            <input type="text" name="location" required value="{{ old('location', $hotel->location) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">City</label>
                            <select name="city" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ old('city', $hotel->city) == $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Hotel Type</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <select id="type_select" name="hotel_type_id" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                        @foreach($hotelTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('hotel_type_id', $hotel->hotel_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" @click="showTypeModal = true" class="px-5 bg-slate-50 text-[#0F4A3B] rounded-2xl hover:bg-[#0F4A3B] hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Price per Night ($)</label>
                            <input type="number" step="0.01" name="price_per_night" required value="{{ old('price_per_night', $hotel->price_per_night) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">{{ old('meta_description', $hotel->meta_description) }}</textarea>
                    </div>

                    <!-- Activities -->
                    <div class="pt-6 border-t border-slate-50 space-y-6">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="text-xs font-black text-[#0F4A3B] uppercase tracking-widest">Hotel Activities / Amenities</h3>
                            <button type="button" @click="addActivity()" class="text-[10px] font-black uppercase text-[#0F4A3B] hover:opacity-70">+ Add Activity</button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="(activity, index) in activities" :key="index">
                                <div class="flex gap-2 p-2 bg-slate-50 rounded-2xl animate-in slide-in-from-top-2">
                                    <input type="text" name="activities[]" x-model="activities[index]" class="flex-1 px-4 py-2 bg-white rounded-xl text-sm font-bold outline-none">
                                    <button type="button" @click="removeActivity(index)" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Image, Star, Status -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <!-- Rating -->
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Star Rating</label>
                        <select name="rating" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            @foreach([5,4,3,2,1] as $star)
                                <option value="{{ $star }}" {{ old('rating', $hotel->rating) == $star ? 'selected' : '' }}>{{ $star }} Stars</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Image -->
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Hotel Image</label>
                        <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="image" @change="previewMedia($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <img :src="preview || '{{ $hotel->image ? Storage::url($hotel->image) : '' }}'" class="w-full h-full object-cover {{ !$hotel->image && !'preview' ? 'hidden' : '' }}" :class="preview || '{{ $hotel->image }}' ? '' : 'hidden'">
                            <div x-show="!preview && !'{{ $hotel->image }}'" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Upload Hotel Image</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active" {{ $hotel->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $hotel->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Update Hotel
                    </button>
                </div>
            </div>
        </form>

        <!-- Type Modal -->
        <div x-show="showTypeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showTypeModal = false"></div>
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 animate-in zoom-in-95 duration-300">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-slate-900">Add Hotel Type</h3>
                    <p class="text-slate-400 font-semibold text-sm">Create a new category (e.g. Boutique, Villa).</p>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Type Name</label>
                        <input type="text" x-model="newTypeName" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>
                    <button type="button" @click="saveType()" class="w-full py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-lg shadow-[#0F4A3B]/20 hover:scale-105 active:scale-95 transition-all">
                        Create Type
                    </button>
                    <button type="button" @click="showTypeModal = false" class="w-full text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition-colors">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function hotelEditor() {
            return {
                showTypeModal: false,
                newTypeName: '',
                activities: {!! json_encode($hotel->activities ?? ['']) !!},
                preview: null,

                addActivity() { this.activities.push(''); },
                removeActivity(index) { this.activities.splice(index, 1); },
                
                previewMedia(e) {
                    const file = e.target.files[0];
                    if (file) this.preview = URL.createObjectURL(file);
                },

                async saveType() {
                    if (!this.newTypeName) return;
                    try {
                        const response = await fetch('{{ route('hotel-types.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: this.newTypeName })
                        });
                        const data = await response.json();
                        if (data.success) {
                            const select = document.getElementById('type_select');
                            const option = new Option(data.type.name, data.type.id);
                            select.add(option);
                            select.value = data.type.id;
                            this.newTypeName = '';
                            this.showTypeModal = false;
                            
                            Swal.fire({
                                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                                icon: 'success', title: 'Hotel type added!'
                            });
                        }
                    } catch (error) {
                        console.error('Error saving type:', error);
                    }
                }
            }
        }
    </script>
</x-app-layout>
