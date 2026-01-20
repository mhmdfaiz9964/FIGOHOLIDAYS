<x-app-layout>
    <div x-data="{ 
        name: '{{ old('name', $partner->name) }}',
        preview: '{{ Storage::url($partner->image) }}',
        handleFile(e) {
            const file = e.target.files[0];
            if (file) this.preview = URL.createObjectURL(file);
        }
    }" class="space-y-10 animate-in fade-in duration-700 pb-20">
        
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('partners.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit Partner</h1>
                <p class="text-slate-400 mt-2 font-semibold">Update details for {{ $partner->name }}.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Form Card -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10">
                <form action="{{ route('partners.update', $partner) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Partner Name</label>
                        <input type="text" name="name" x-model="name" required 
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="e.g. Travel Group Intl">
                        @error('name') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Update Logo (Optional)</label>
                        <div class="relative group">
                            <input type="file" name="image" @change="handleFile"
                                class="w-full px-6 py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] font-bold text-slate-400 cursor-pointer hover:bg-slate-100 hover:border-[#0F4A3B]/20 transition-all flex flex-col items-center">
                            
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <svg class="w-10 h-10 text-slate-300 group-hover:text-[#0F4A3B]/30 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-sm font-black text-slate-300 mt-2 uppercase tracking-widest">Change Image</p>
                            </div>
                        </div>
                        @error('image') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex gap-4">
                        <a href="{{ route('partners.index') }}" class="px-8 py-5 bg-slate-50 text-slate-400 rounded-2xl font-bold hover:bg-slate-100 transition-all">Cancel</a>
                        <button type="submit" class="flex-1 py-5 bg-[#0F4A3B] text-white rounded-2xl font-black text-lg shadow-xl shadow-[#0F4A3B]/20 hover:opacity-95 transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Card -->
            <div class="space-y-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-2">Visual Preview</p>
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-12 flex flex-col items-center justify-center min-h-[400px]">
                    <div class="w-full max-w-sm aspect-square bg-slate-50 rounded-[2rem] overflow-hidden flex items-center justify-center border border-dashed border-slate-200 relative">
                        <img :src="preview" class="max-w-full max-h-full object-contain p-8">
                    </div>
                    
                    <div class="mt-8 text-center" x-show="name">
                        <h3 class="text-2xl font-black text-slate-900" x-text="name"></h3>
                        <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest italic">Existing Membership</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
