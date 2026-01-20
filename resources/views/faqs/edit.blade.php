<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('faqs.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit FAQ</h1>
                <p class="text-slate-400 mt-2 font-semibold">Update help topic or policy explanation.</p>
            </div>
        </div>

        <form action="{{ route('faqs.update', $faq) }}" method="POST" class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-3 space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Question / Topic</label>
                    <input type="text" name="question" value="{{ $faq->question }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Display Order</label>
                    <input type="number" name="order" value="{{ $faq->order }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Detailed Answer</label>
                <div class="ck-editor-container">
                    <textarea id="editor" name="answer">{!! $faq->answer !!}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <div class="flex items-center gap-4">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Global Status</label>
                    <div class="flex bg-slate-100 p-1.5 rounded-xl">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="active" {{ $faq->status == 'active' ? 'checked' : '' }} class="peer hidden">
                            <span class="px-6 py-2 rounded-lg text-[10px] font-black uppercase peer-checked:bg-[#0F4A3B] peer-checked:text-white transition-all block">Active</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="inactive" {{ $faq->status == 'inactive' ? 'checked' : '' }} class="peer hidden">
                            <span class="px-6 py-2 rounded-lg text-[10px] font-black uppercase peer-checked:bg-rose-500 peer-checked:text-white transition-all block">Inactive</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="px-12 py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-105 active:scale-95 transition-all text-sm">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <style>
        .ck-editor__editable { min-height: 250px; border-radius: 0 0 1.5rem 1.5rem !important; border-color: #f1f5f9 !important; padding: 0 2rem !important; }
        .ck-toolbar { border-radius: 1.5rem 1.5rem 0 0 !important; border-color: #f1f5f9 !important; padding: 10px !important; }
        .ck-editor__editable_focused { box-shadow: none !important; border-color: #0F4A3B33 !important; }
    </style>
</x-app-layout>
