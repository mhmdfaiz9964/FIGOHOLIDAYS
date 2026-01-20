<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Visa Pages</h1>
                <p class="text-slate-400 mt-2 font-semibold">Manage visa requirement details and documentation.</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('visas.index') }}" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search visas..." class="pl-12 pr-6 py-3.5 bg-white border border-slate-100 rounded-2xl font-bold text-sm text-slate-900 focus:border-[#0F4A3B]/20 outline-none w-64 transition-all shadow-sm">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-[#0F4A3B] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </form>
                <a href="{{ route('visas.create') }}" class="flex items-center gap-2 px-6 py-3.5 bg-[#0F4A3B] text-white rounded-2xl font-bold text-sm hover:opacity-90 shadow-xl shadow-[#0F4A3B]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Visa Page
                </a>
            </div>
        </div>

        <!-- Visas List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden pb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Visa Details</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($visas as $visa)
                            <tr class="group hover:bg-slate-50/30 transition-all duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-14 rounded-xl overflow-hidden bg-slate-100 shadow-sm">
                                            @if($visa->image)
                                                <img src="{{ Storage::url($visa->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400 font-black italic text-[8px]">NO IMAGE</div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-900 text-sm whitespace-nowrap">{{ $visa->title }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $visa->update_title ?: 'Standard' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('visas.edit', $visa) }}" class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <button onclick="confirmDeleteVisa('{{ $visa->id }}')" class="p-3 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-100 transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                        <form id="delete-form-{{ $visa->id }}" action="{{ route('visas.destroy', $visa) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="px-8 py-20 text-center text-slate-400 font-bold italic">No visa pages found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($visas->hasPages())
                <div class="p-8 border-t border-slate-50 bg-slate-50/30">{{ $visas->links() }}</div>
            @endif
        </div>
    </div>

    <script>
        function confirmDeleteVisa(id) {
            Swal.fire({
                title: 'Delete Visa Page?',
                text: "Removing this page will delete all visa requirements listed.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0F4A3B',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Delete',
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
