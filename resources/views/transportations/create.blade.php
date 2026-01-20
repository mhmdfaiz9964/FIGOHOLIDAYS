<x-app-layout>
    <div x-data="transportEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('transportations.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Add Transportation</h1>
                <p class="text-slate-400 mt-2 font-semibold">Define vehicle details, pricing, and inclusions.</p>
            </div>
        </div>

        <form action="{{ route('transportations.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf

            <!-- Left Col: Basics -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Service Title</label>
                            <input type="text" name="title" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="e.g. Private Luxury SUV Transfer">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Vehicle Type</label>
                            <input type="text" name="vehicle_type" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="e.g. Luxury, Sedan, Mini Bus">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Starting Price ($)</label>
                            <input type="number" step="0.01" name="starting_price" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Includes Section -->
                    <div class="pt-6 border-t border-slate-50 space-y-6">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="text-xs font-black text-[#0F4A3B] uppercase tracking-widest">Inclusions (JSON Format)</h3>
                            <button type="button" @click="addInclude()" class="text-[10px] font-black uppercase text-[#0F4A3B] hover:opacity-70">+ Add Include</button>
                        </div>
                        
                        <div class="space-y-4">
                            <template x-for="(item, index) in includes" :key="item.id">
                                <div class="flex flex-col md:flex-row gap-4 p-4 bg-slate-50 rounded-2xl animate-in slide-in-from-top-2">
                                    <div class="flex-1 space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Include Title</label>
                                        <input type="text" :name="'includes['+index+'][title]'" x-model="item.title" class="w-full px-4 py-2 bg-white rounded-xl text-sm font-bold outline-none">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase">Icon</label>
                                        <div class="relative w-full md:w-32 h-10 bg-white rounded-xl border border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                                            <input type="file" :name="'includes['+index+'][icon]'" class="absolute inset-0 opacity-0 cursor-pointer">
                                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" @click="removeInclude(index)" class="p-2.5 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Images & Status -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Vehicle Image</label>
                        <div class="relative aspect-[4/3] bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="vehicle_image" @change="previewMedia($event, 'vehicle')" required class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <template x-if="previews.vehicle">
                                <img :src="previews.vehicle" class="w-full h-full object-cover">
                            </template>
                            <div x-show="!previews.vehicle" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Upload vehicle</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Label Icon (Small)</label>
                        <div class="relative w-20 h-20 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="label_icon" @change="previewMedia($event, 'icon')" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <template x-if="previews.icon">
                                <img :src="previews.icon" class="w-full h-full object-contain p-2">
                            </template>
                            <div x-show="!previews.icon" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Visibility Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all appearance-none">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Save Transportation
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function transportEditor() {
            return {
                includes: [{ id: Date.now(), title: '' }],
                previews: { vehicle: null, icon: null },
                
                addInclude() { this.includes.push({ id: Date.now(), title: '' }); },
                removeInclude(index) { this.includes.splice(index, 1); },
                
                previewMedia(e, type) {
                    const file = e.target.files[0];
                    if (file) this.previews[type] = URL.createObjectURL(file);
                }
            }
        }
    </script>
</x-app-layout>
