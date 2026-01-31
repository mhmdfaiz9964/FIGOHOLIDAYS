<x-app-layout>
    <div x-data="destinationEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('destinations.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit Destination</h1>
                <p class="text-slate-400 mt-2 font-semibold">Update location details and tourist interest points.</p>
            </div>
        </div>

        <form action="{{ route('destinations.update', $destination) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            @method('PUT')

            <!-- Left Col: Basics -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Destination Name</label>
                            <input type="text" name="name" value="{{ old('name', $destination->name) }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Province</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <select id="province_select" name="province_id" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                                        <option value="">Select Province</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $destination->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" @click="showProvinceModal = true" class="px-5 bg-slate-50 text-[#0F4A3B] rounded-2xl hover:bg-[#0F4A3B] hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Label / Tag</label>
                            <input type="text" name="label" value="{{ old('label', $destination->label) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 space-y-6">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="text-xs font-black text-[#0F4A3B] uppercase tracking-widest">Top Tourist Attractions</h3>
                            <button type="button" @click="addAttraction()" class="text-[10px] font-black uppercase text-[#0F4A3B] hover:opacity-70">+ Add Attraction</button>
                        </div>
                        
                        <div class="space-y-4">
                            <template x-for="(attraction, index) in attractions" :key="index">
                                <div class="flex flex-col md:flex-row gap-4 p-4 bg-slate-50 rounded-2xl animate-in slide-in-from-top-2">
                                    <div class="flex-1 space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Attraction Name</label>
                                        <input type="text" :name="'attractions['+index+'][title]'" x-model="attraction.title" class="w-full px-4 py-2 bg-white rounded-xl text-sm font-bold outline-none" placeholder="e.g. Temple of the Tooth">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Image</label>
                                        <div class="relative w-full md:w-32 h-20 bg-white rounded-xl border border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                                            <input type="file" :name="'attractions['+index+'][image]'" @change="previewAttraction($event, index)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                            <input type="hidden" :name="'attractions['+index+'][old_image]'" x-model="attraction.image">
                                            
                                            <template x-if="attraction.preview">
                                                <img :src="attraction.preview" class="w-full h-full object-cover">
                                            </template>
                                            
                                            <template x-if="!attraction.preview && attraction.image">
                                                <img :src="'/storage/' + attraction.image" class="w-full h-full object-cover">
                                            </template>

                                            <template x-if="!attraction.preview && !attraction.image">
                                                <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" @click="removeAttraction(index)" class="p-2.5 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Description</label>
                        <div class="ck-editor-container">
                            <textarea id="description_editor" name="description">{{ old('description', $destination->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Image & Status -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Feature Image</label>
                        <div class="relative aspect-[4/3] bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="image" @change="previewMedia($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <img :src="preview || '{{ Storage::url($destination->image) }}'" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active" {{ $destination->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $destination->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Update Destination
                    </button>
                </div>
            </div>
        </form>

        <!-- Province Modal (Same as Create) -->
        <div x-show="showProvinceModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showProvinceModal = false"></div>
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 animate-in zoom-in-95 duration-300">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-slate-900">Add New Province</h3>
                    <p class="text-slate-400 font-semibold text-sm">Create a regional category for destinations.</p>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Province Name</label>
                        <input type="text" x-model="newProvinceName" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                    </div>
                    <button type="button" @click="saveProvince()" class="w-full py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-lg shadow-[#0F4A3B]/20 hover:scale-105 active:scale-95 transition-all">
                        Create Province
                    </button>
                    <button type="button" @click="showProvinceModal = false" class="w-full text-xs font-black text-slate-400 uppercase hover:text-slate-600 transition-colors">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#description_editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        }).catch(error => console.error(error));

        function destinationEditor() {
            return {
                showProvinceModal: false,
                newProvinceName: '',
                attractions: {!! json_encode(array_map(function($attraction) {
                    if (is_string($attraction)) {
                        return ['title' => $attraction, 'image' => null, 'preview' => null];
                    }
                    $attraction['preview'] = null;
                    return $attraction;
                }, $destination->attractions ?? [])) !!},
                preview: null,

                addAttraction() { this.attractions.push({ title: '', image: null, preview: null }); },
                removeAttraction(index) { this.attractions.splice(index, 1); },
                
                previewAttraction(e, index) {
                    const file = e.target.files[0];
                    if (file) {
                        this.attractions[index].preview = URL.createObjectURL(file);
                    }
                },

                previewMedia(e) {
                    const file = e.target.files[0];
                    if (file) this.preview = URL.createObjectURL(file);
                },

                async saveProvince() {
                    if (!this.newProvinceName) return;
                    try {
                        const response = await fetch('{{ route('provinces.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: this.newProvinceName })
                        });
                        const data = await response.json();
                        if (data.success) {
                            const select = document.getElementById('province_select');
                            const option = new Option(data.province.name, data.province.id);
                            select.add(option);
                            select.value = data.province.id;
                            this.newProvinceName = '';
                            this.showProvinceModal = false;
                            
                            Swal.fire({
                                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                                icon: 'success', title: 'Province added!'
                            });
                        }
                    } catch (error) {
                        console.error('Error saving province:', error);
                    }
                }
            }
        }
    </script>
    <style>
        .ck-editor__editable { min-height: 200px; border-radius: 0 0 1.5rem 1.5rem !important; border-color: #f1f5f9 !important; padding: 0 2rem !important; }
        .ck-toolbar { border-radius: 1.5rem 1.5rem 0 0 !important; border-color: #f1f5f9 !important; padding: 10px !important; }
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
