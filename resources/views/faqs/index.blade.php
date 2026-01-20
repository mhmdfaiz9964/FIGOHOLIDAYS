<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">FAQ Management</h1>
                <p class="text-slate-400 mt-2 font-semibold">Organize frequently asked questions for your users.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('faqs.create') }}" class="flex items-center gap-2 px-6 py-3.5 bg-[#0F4A3B] text-white rounded-2xl font-bold text-sm hover:opacity-90 shadow-xl shadow-[#0F4A3B]/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Question
                </a>
            </div>
        </div>

        <!-- FAQ List -->
        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden pb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Order</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Question & Answer Preview</th>
                            <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($faqs as $faq)
                            <tr class="group hover:bg-slate-50/10 transition-all">
                                <td class="px-8 py-6">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center font-black text-slate-400 text-xs">
                                        {{ $faq->order }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div>
                                        <h4 class="font-black text-slate-900 text-lg">{{ $faq->question }}</h4>
                                        <div class="text-slate-400 text-xs mt-1 line-clamp-1 italic">
                                            {!! strip_tags($faq->answer) !!}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('faqs.edit', $faq) }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] hover:border-[#0F4A3B]/20 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <button onclick="confirmDeleteFaq('{{ $faq->id }}')" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-rose-600 hover:border-rose-100 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                        <form id="delete-form-{{ $faq->id }}" action="{{ route('faqs.destroy', $faq) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-8 py-20 text-center text-slate-400 font-bold">No FAQs found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($faqs->hasPages())
                <div class="p-8 border-t border-slate-50">{{ $faqs->links() }}</div>
            @endif
        </div>
    </div>

    <script>
        function confirmDeleteFaq(id) {
            Swal.fire({
                title: 'Delete Question?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0F4A3B',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-'+id).submit();
            })
        }
    </script>
</x-app-layout>
