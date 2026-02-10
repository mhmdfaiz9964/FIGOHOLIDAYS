<x-app-layout>
    <div x-data="{ 
        name: '{{ old('name', $category->name) }}',
        slug: '{{ old('slug', $category->slug) }}',
        sub_heading: '{{ old('sub_heading', $category->sub_heading) }}',
        preview: '{{ $category->banner_image ? Storage::url($category->banner_image) : null }}',
        showTypeModal: false,
        newTypeName: '',
        categoryId: {{ $category->id }},
        isNameUnique: true,
        isSlugUnique: true,
        handleFile(e) {
            const file = e.target.files[0];
            if (file) this.preview = URL.createObjectURL(file);
        },
        updateSlug() {
            this.slug = this.name.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
            this.checkUniqueness('name', this.name);
            this.checkUniqueness('slug', this.slug);
        },
        async checkUniqueness(field, value) {
            if (!value) return;
            try {
                const response = await fetch(`{{ route('offer-categories.check-uniqueness') }}?field=${field}&value=${value}${this.categoryId ? '&id=' + this.categoryId : ''}`);
                const data = await response.json();
                if (field === 'name') this.isNameUnique = data.unique;
                if (field === 'slug') this.isSlugUnique = data.unique;
            } catch (error) {
                console.error('Uniqueness check failed:', error);
            }
        },
        async createType() {
            if (!this.newTypeName) return;
            try {
                const response = await fetch('{{ route('offer-types.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: this.newTypeName })
                });
                const result = await response.json();
                if (result.status === 'success') {
                    const container = document.getElementById('types-container');
                    const newId = result.data.id;
                    const newName = result.data.name;

                    const label = document.createElement('label');
                    label.className = 'relative cursor-pointer group';
                    label.innerHTML = `
                        <input type='checkbox' name='types[]' value='${newId}' class='peer hidden' checked>
                        <div class='px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-center transition-all peer-checked:bg-[#0F4A3B]/5 peer-checked:border-[#0F4A3B]/20 peer-checked:text-[#0F4A3B] group-hover:bg-slate-100'>
                            <span class='text-[10px] font-black uppercase tracking-widest'>${newName}</span>
                        </div>
                    `;
                    container.appendChild(label);

                    this.showTypeModal = false;
                    this.newTypeName = '';
                } else {
                    alert(result.message || 'Error creating type');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while creating the type');
            }
        }
    }" class="space-y-10 animate-in fade-in duration-700 pb-20">

        <!-- Header -->
        <div class="flex items-center gap-6">
            <a href="{{ route('offer-categories.index') }}"
                class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit Category</h1>
                <p class="text-slate-400 mt-2 font-semibold">Modify category details for {{ $category->name }}.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Form Card -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10">
                <form action="{{ route('offer-categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Category
                                Name</label>
                            <input type="text" name="name" x-model="name" @input="updateSlug" required
                                :class="{'border-rose-500 focus:border-rose-500 focus:ring-rose-500/5': !isNameUnique}"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none"
                                placeholder="e.g. Honeymoon Special">
                            <p x-show="!isNameUnique"
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                This name is already taken
                            </p>
                            @error('name') <p
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Category
                                Slug</label>
                            <input type="text" name="slug" x-model="slug" required
                                @input="checkUniqueness('slug', slug)"
                                :class="{'border-rose-500 focus:border-rose-500 focus:ring-rose-500/5': !isSlugUnique}"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-500 text-sm focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none"
                                placeholder="honeymoon-special">
                            <p x-show="!isSlugUnique"
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                This slug is already taken
                            </p>
                            @error('slug') <p
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label
                                    class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Associated
                                    Types</label>
                                <button type="button" @click="showTypeModal = true"
                                    class="p-2 bg-slate-50 rounded-lg text-[#0F4A3B] hover:bg-slate-100 transition-all flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-4" id="types-container">
                                @php
                                    $selectedTypeIds = $category->types->pluck('id')->toArray();
                                @endphp
                                @foreach($types as $type)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="types[]" value="{{ $type->id }}" class="peer hidden" {{ in_array($type->id, $selectedTypeIds) ? 'checked' : '' }}>
                                        <div
                                            class="px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl text-center transition-all peer-checked:bg-[#0F4A3B]/5 peer-checked:border-[#0F4A3B]/20 peer-checked:text-[#0F4A3B] group-hover:bg-slate-100">
                                            <span
                                                class="text-[10px] font-black uppercase tracking-widest">{{ $type->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Meta
                                Title</label>
                            <input type="text" name="title" value="{{ old('title', $category->title) }}" required
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none"
                                placeholder="A short catchy title for SEO">
                            @error('title') <p
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Sub
                                Heading</label>
                            <input type="text" name="sub_heading" x-model="sub_heading"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none"
                                placeholder="Secondary information for the banner">
                            @error('sub_heading') <p
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Visibility
                                Status</label>
                            <select name="status" required
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 transition-all outline-none appearance-none">
                                <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status') <p
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Update
                                Banner (Optional)</label>
                            <input type="file" name="banner_image" @change="handleFile"
                                class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-400 cursor-pointer">
                            @error('banner_image') <p
                                class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 px-1">
                                {{ $message }}
                            </p> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex gap-4">
                        <a href="{{ route('offer-categories.index') }}"
                            class="px-8 py-5 bg-slate-50 text-slate-400 rounded-2xl font-bold hover:bg-slate-100 transition-all">Cancel</a>
                        <button type="submit" :disabled="!isNameUnique || !isSlugUnique"
                            :class="{'opacity-50 cursor-not-allowed': !isNameUnique || !isSlugUnique}"
                            class="flex-1 py-5 bg-[#0F4A3B] text-white rounded-2xl font-black text-lg shadow-xl shadow-[#0F4A3B]/20 hover:opacity-95 transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Card -->
            <div class="space-y-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-2">Visual Preview</p>
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden group">
                    <div class="relative h-64 bg-slate-900 overflow-hidden flex items-center justify-center">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <p class="text-[10px] font-black text-white/20 uppercase tracking-widest">Banner Placeholder
                            </p>
                        </template>
                        <div class="absolute inset-0 bg-black/30"></div>
                        <div class="absolute bottom-8 left-8 text-white">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80" x-text="name"></p>
                            <h3 class="text-3xl font-black mt-1" x-text="name"></h3>
                            <p class="text-sm font-bold mt-2 text-white/70" x-text="sub_heading"></p>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-emerald-100">Visibility:
                                <span x-text="$root.querySelector('select').value"></span></span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight"
                                x-text="'slug: ' + slug"></span>
                        </div>
                        <p class="text-sm font-bold text-slate-400">Current record ID: {{ $category->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Type Modal -->
        <div x-show="showTypeModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showTypeModal = false"
                class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md p-10 space-y-8 animate-in zoom-in duration-300">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Add New Type</h3>
                    <p class="text-slate-400 font-semibold mt-1">Create a new offer type to associate with this
                        category.</p>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Type
                            Name</label>
                        <input type="text" x-model="newTypeName" @keydown.enter="createType"
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 transition-all outline-none"
                            placeholder="e.g. Adventure">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" @click="showTypeModal = false"
                        class="flex-1 py-4 bg-slate-50 text-slate-400 rounded-2xl font-bold hover:bg-slate-100 transition-all">Cancel</button>
                    <button type="button" @click="createType"
                        class="flex-1 py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-lg shadow-[#0F4A3B]/20 hover:opacity-95 transition-all">Create
                        Type</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>