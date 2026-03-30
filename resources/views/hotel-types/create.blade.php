<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('hotel-types.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Create Hotel Type</h1>
                <p class="text-slate-400 mt-2 font-semibold">Add a new category for hotel classification.</p>
            </div>
        </div>

        <form action="{{ route('hotel-types.store') }}" method="POST" class="max-w-2xl mx-auto space-y-8">
            @csrf
            
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                <div class="space-y-4">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Type Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Luxury Resort"
                        class="w-full px-8 py-5 bg-slate-50 border border-slate-100/50 rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 transition-all outline-none">
                    @error('name')
                        <p class="text-rose-500 text-xs font-bold px-1 mt-2 tracking-tight">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 justify-center">
                <button type="submit" class="px-12 py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-105 active:scale-95 transition-all">
                    Create Hotel Type
                </button>
                <a href="{{ route('hotel-types.index') }}" class="px-10 py-5 bg-white border border-slate-100 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
