<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Hotel Types</h1>
                <p class="text-slate-400 mt-2 font-semibold">Manage different categories of hotel accommodations.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('hotel-types.create') }}" class="flex items-center gap-2 px-6 py-3.5 bg-[#0F4A3B] text-white rounded-2xl font-bold text-sm hover:opacity-90 shadow-xl shadow-[#0F4A3B]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Hotel Type
                </a>
            </div>
        </div>

        <!-- Types Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest"># ID</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Type Name</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Created At</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($types as $type)
                            <tr class="group hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-6">
                                    <span class="text-sm font-bold text-slate-400">#{{ $type->id }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-black text-slate-900 text-base tracking-tight">{{ $type->name }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-xs font-bold text-slate-400">{{ $type->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2 text-slate-400">
                                        <a href="{{ route('hotel-types.edit', $type) }}" class="p-2.5 bg-white border border-slate-100 rounded-xl hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button onclick="confirmDelete('{{ $type->id }}', 'Delete this hotel type?')" class="p-2.5 bg-white border border-slate-100 rounded-xl hover:text-rose-600 hover:border-rose-100 hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <form id="delete-form-{{ $type->id }}" action="{{ route('hotel-types.destroy', $type) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center gap-4">
                                        <div class="w-20 h-20 rounded-[2rem] bg-slate-50 flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 font-bold">No hotel types found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($types->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
                    {{ $types->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDelete(id, message) {
            Swal.fire({
                title: 'Are you sure?',
                text: message || "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0F4A3B',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    container: 'font-sans',
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3',
                    cancelButton: 'rounded-xl px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
