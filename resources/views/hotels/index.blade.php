<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Hotels</h1>
                <p class="text-slate-400 mt-2 font-semibold">Manage luxury stays, boutique hotels, and cabanas.</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('hotels.index') }}" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search hotels..." class="pl-12 pr-6 py-3.5 bg-white border border-slate-100 rounded-2xl font-bold text-sm text-slate-900 focus:border-[#0F4A3B]/20 outline-none w-64 transition-all shadow-sm">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-[#0F4A3B] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </form>
                <a href="{{ route('hotels.create') }}" class="flex items-center gap-2 px-6 py-3.5 bg-[#0F4A3B] text-white rounded-2xl font-bold text-sm hover:opacity-90 shadow-xl shadow-[#0F4A3B]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Hotel
                </a>
            </div>
        </div>

        <!-- Hotels List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden pb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Hotel</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Type</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Pricing</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Rating</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($hotels as $hotel)
                            <tr class="group hover:bg-slate-50/30 transition-all duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-12 rounded-xl overflow-hidden bg-slate-100 shadow-sm border border-slate-50">
                                            @if($hotel->image)
                                                <img src="{{ Storage::url($hotel->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-900 text-sm whitespace-nowrap">{{ $hotel->name }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $hotel->city }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="px-3 py-1 bg-[#0F4A3B]/5 text-[#0F4A3B] text-[10px] font-black uppercase tracking-widest rounded-lg">
                                        {{ $hotel->hotelType->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-sm font-black text-slate-900">${{ number_format($hotel->price_per_night, 2) }}</span>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-0.5">/ Night</p>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex items-center justify-center gap-0.5 whitespace-nowrap">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $hotel->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $hotel->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $hotel->status === 'active' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        {{ $hotel->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('hotels.edit', $hotel) }}" class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <button onclick="confirmDeleteHotel('{{ $hotel->id }}')" class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-100 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                        <form id="delete-form-{{ $hotel->id }}" action="{{ route('hotels.destroy', $hotel) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold italic">No hotels found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($hotels->hasPages())
                <div class="p-8 border-t border-slate-50 bg-slate-50/30">{{ $hotels->links() }}</div>
            @endif
        </div>
    </div>

    <script>
        function confirmDeleteHotel(id) {
            Swal.fire({
                title: 'Delete Hotel?',
                text: "Removing this hotel will delete all its records and ratings.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0F4A3B',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Yes, delete it',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-10 py-3 font-black text-xs uppercase tracking-widest',
                    cancelButton: 'rounded-xl px-10 py-3 font-black text-xs uppercase tracking-widest'
                }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-'+id).submit();
            })
        }
    </script>
</x-app-layout>
