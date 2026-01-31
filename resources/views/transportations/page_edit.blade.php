<x-app-layout>
    <div x-data="pageEditor()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('transportations.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Transportation Page Settings</h1>
                <p class="text-slate-400 mt-2 font-semibold">Customize the landing page content, images, and FAQs.</p>
            </div>
        </div>

        <form action="{{ route('transportations.page.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            
            <!-- Left Col: Content & FAQs -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="grid grid-cols-1 gap-8">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Main Heading</label>
                            <input type="text" name="main_title" value="{{ old('main_title', $page->main_title) }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Sub Heading / Price Info</label>
                            <input type="text" name="main_subtitle" value="{{ old('main_subtitle', $page->main_subtitle) }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>

                    <!-- FAQs Section -->
                    <div class="pt-6 border-t border-slate-50 space-y-6">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="text-xs font-black text-[#0F4A3B] uppercase tracking-widest">Questions & Answers (FAQs)</h3>
                            <button type="button" @click="addFaq()" class="text-[10px] font-black uppercase text-[#0F4A3B] hover:opacity-70">+ Add FAQ</button>
                        </div>
                        
                        <div class="space-y-6">
                            <template x-for="(faq, index) in faqs" :key="index">
                                <div class="p-6 bg-slate-50 rounded-3xl relative group animate-in slide-in-from-top-2">
                                    <button type="button" @click="removeFaq(index)" class="absolute -top-2 -right-2 w-8 h-8 bg-white border border-slate-100 text-rose-500 rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-all hover:scale-110">
                                        &times;
                                    </button>
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-300 uppercase">Question</label>
                                            <input type="text" :name="'faqs['+index+'][question]'" x-model="faq.question" class="w-full px-4 py-2 bg-white rounded-xl text-sm font-bold outline-none" placeholder="Enter question...">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[10px] font-black text-slate-300 uppercase">Answer</label>
                                            <textarea :name="'faqs['+index+'][answer]'" x-model="faq.answer" rows="3" class="w-full px-4 py-2 bg-white rounded-xl text-sm font-bold outline-none resize-none" placeholder="Enter answer..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="faqs.length === 0" class="py-10 text-center border-2 border-dashed border-slate-100 rounded-3xl">
                                <p class="text-slate-300 text-sm font-bold">No FAQs added yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Images -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <!-- Image 01 -->
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Top Display Image (01)</label>
                        <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="image_01" @change="previewMedia($event, 'image01')" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            
                            <img x-show="previews.image01" :src="previews.image01" class="w-full h-full object-cover">
                            
                            @if($page->image_01)
                                <img x-show="!previews.image01" src="{{ Storage::url($page->image_01) }}" class="w-full h-full object-cover">
                            @endif

                            <div x-show="!previews.image01 && !'{{ $page->image_01 }}'" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Upload Image 01</p>
                            </div>
                        </div>
                    </div>

                    <!-- Image 02 -->
                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Bottom Display Image (02)</label>
                        <div class="relative aspect-video bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                            <input type="file" name="image_02" @change="previewMedia($event, 'image02')" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            
                            <img x-show="previews.image02" :src="previews.image02" class="w-full h-full object-cover">
                            
                            @if($page->image_02)
                                <img x-show="!previews.image02" src="{{ Storage::url($page->image_02) }}" class="w-full h-full object-cover">
                            @endif

                            <div x-show="!previews.image02 && !'{{ $page->image_02 }}'" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-[10px] font-black uppercase mt-2">Upload Image 02</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all mt-4">
                        Update Page Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function pageEditor() {
            return {
                faqs: @json($page->faqs ?? []),
                previews: { image01: null, image02: null },
                
                addFaq() {
                    this.faqs.push({ question: '', answer: '' });
                },
                removeFaq(index) {
                    this.faqs.splice(index, 1);
                },
                previewMedia(e, key) {
                    const file = e.target.files[0];
                    if (file) {
                        this.previews[key] = URL.createObjectURL(file);
                    }
                }
            }
        }
    </script>
</x-app-layout>
