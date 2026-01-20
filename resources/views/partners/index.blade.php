<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Our Partners</h1>
                <p class="text-slate-400 mt-2 font-semibold">Manage your collaboration partners in a detailed list view.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('partners.create') }}" class="flex items-center gap-2 px-6 py-3.5 bg-[#0F4A3B] text-white rounded-2xl font-bold text-sm hover:opacity-90 shadow-xl shadow-[#0F4A3B]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Partner
                </a>
            </div>
        </div>

        <!-- Search & Info -->
        <div class="flex flex-col md:flex-row gap-6 items-center justify-between">
            <form action="{{ route('partners.index') }}" method="GET" class="w-full md:max-w-md relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-[#0F4A3B] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search partners..." 
                    class="w-full pl-12 pr-6 py-4 bg-white border border-slate-100 rounded-2xl font-bold text-slate-900 focus:ring-4 focus:ring-[#0F4A3B]/5 focus:border-[#0F4A3B]/20 transition-all shadow-sm outline-none">
            </form>
            <div class="flex items-center gap-2 text-slate-400 text-sm font-bold bg-white px-6 py-4 rounded-2xl border border-slate-50 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ $partners->total() }} Partners Found
            </div>
        </div>

        <!-- Partners List View (Table) -->
        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Partner Logo</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Partner Name</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Date Added</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($partners as $partner)
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-6">
                                    <div class="w-20 h-12 bg-slate-50 rounded-xl overflow-hidden flex items-center justify-center p-2 border border-slate-100 group-hover:scale-110 transition-transform duration-500">
                                        <img src="{{ Storage::url($partner->image) }}" class="max-w-full max-h-full object-contain" alt="{{ $partner->name }}">
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-black text-slate-900 text-base tracking-tight">{{ $partner->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Official Partner</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-sm font-bold text-slate-600">{{ $partner->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        Active
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('partners.edit', $partner) }}" class="p-2.5 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button onclick="confirmDelete('{{ $partner->id }}', 'Delete {{ $partner->name }}?')" class="p-2.5 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-100 hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <form id="delete-form-{{ $partner->id }}" action="{{ route('partners.destroy', $partner) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center gap-4">
                                        <div class="w-20 h-20 rounded-[2rem] bg-slate-50 flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-bold">No partners found matching your search.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($partners->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
                    {{ $partners->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
