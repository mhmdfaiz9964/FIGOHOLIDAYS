<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Holiday Offers</h1>
                <p class="text-slate-400 mt-2 font-semibold">Manage your destination packages, itineraries, and media.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('offers.create') }}" class="flex items-center gap-2 px-6 py-3.5 bg-[#0F4A3B] text-white rounded-2xl font-bold text-sm hover:opacity-90 shadow-xl shadow-[#0F4A3B]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Offer
                </a>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white p-4 rounded-[2rem] border border-slate-50 shadow-sm">
            <form action="{{ route('offers.index') }}" method="GET" class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by offer title..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent rounded-xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 transition-all outline-none">
            </form>
        </div>

        <!-- Offers Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Offer</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Pricing</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Duration</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($offers as $offer)
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 shadow-sm group-hover:scale-105 transition-transform duration-500">
                                            <img src="{{ Storage::url($offer->thumbnail_image) }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-900 text-base">{{ $offer->title }}</p>
                                            <p class="text-[10px] font-bold text-[#0F4A3B] uppercase tracking-widest tracking-widest mt-0.5">{{ $offer->category->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-black text-slate-900">${{ number_format($offer->price, 2) }}</p>
                                    @if($offer->offer_price)
                                        <p class="text-xs font-bold text-rose-500 line-through opacity-50">${{ number_format($offer->offer_price, 2) }}</p>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-sm font-bold text-slate-600">
                                    {{ $offer->days }} Days / {{ $offer->nights }} Nights
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $offer->status === 'active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                        {{ $offer->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2 text-slate-400">
                                        <a href="{{ route('offers.edit', $offer) }}" class="p-2.5 bg-white border border-slate-100 rounded-xl hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <button onclick="confirmDelete('{{ $offer->id }}')" class="p-2.5 bg-white border border-slate-100 rounded-xl hover:text-rose-600 hover:border-rose-100 hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                        <form id="delete-form-{{ $offer->id }}" action="{{ route('offers.destroy', $offer) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold">No offers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($offers->hasPages())
                <div class="px-8 py-6 border-t border-slate-50">{{ $offers->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
