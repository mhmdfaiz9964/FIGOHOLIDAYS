<x-app-layout>
    <div x-data="settingsManager()" class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Site Settings</h1>
                <p class="text-slate-400 mt-2 font-semibold">Global configuration for branding, contact, and homepage metrics.</p>
            </div>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Branding Section -->
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="flex items-center gap-3 border-b border-slate-50 pb-6">
                        <div class="p-3 bg-emerald-50 text-[#0F4A3B] rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Branding & Identity</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-4 text-center">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Main Logo</label>
                            <div class="relative aspect-square w-full bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 overflow-hidden group">
                                <input type="file" name="logo" @change="previewLogo($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <img :src="logoPreview || '{{ $settings->logo ? Storage::url($settings->logo) : 'https://placehold.co/200x200?text=Logo' }}'" class="w-full h-full object-contain p-4">
                            </div>
                        </div>
                        <div class="space-y-4 text-center">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Footer Logo</label>
                            <div class="relative aspect-square w-full bg-slate-900 rounded-3xl border-2 border-dashed border-slate-700 overflow-hidden group">
                                <input type="file" name="footer_logo" @change="previewFooterLogo($event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <img :src="footerLogoPreview || '{{ $settings->footer_logo ? Storage::url($settings->footer_logo) : 'https://placehold.co/200x200?text=Dark+Logo' }}'" class="w-full h-full object-contain p-4">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1 text-left block">Footer Description</label>
                        <textarea name="footer_description" rows="4" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="Enter a brief company bio for the footer...">{{ $settings->footer_description }}</textarea>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="flex items-center gap-3 border-b border-slate-50 pb-6">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Contact Details</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Head Offices -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Head Office Addresses</label>
                                <button type="button" @click="addOffice()" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">+ Add Office</button>
                            </div>
                            <template x-for="(office, index) in headOffices" :key="index">
                                <div class="flex gap-3">
                                    <input type="text" name="head_offices[]" x-model="headOffices[index]" class="flex-1 px-6 py-3 bg-slate-50 rounded-xl text-xs font-bold outline-none border border-transparent focus:bg-white focus:border-[#0F4A3B]/10" placeholder="Office address...">
                                    <button type="button" @click="removeOffice(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                </div>
                            </template>
                        </div>

                        <!-- Whatsapps -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">WhatsApp Numbers</label>
                                <button type="button" @click="addWhatsapp()" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">+ Add WhatsApp</button>
                            </div>
                            <template x-for="(wa, index) in whatsapps" :key="index">
                                <div class="flex gap-3">
                                    <input type="text" name="whatsapps[]" x-model="whatsapps[index]" class="flex-1 px-6 py-3 bg-slate-50 rounded-xl text-xs font-bold outline-none border border-transparent focus:bg-white focus:border-[#0F4A3B]/10" placeholder="+94 ...">
                                    <button type="button" @click="removeWhatsapp(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                </div>
                            </template>
                        </div>

                        <!-- Landlines -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Landline Numbers</label>
                                <button type="button" @click="addLandline()" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">+ Add Landline</button>
                            </div>
                            <template x-for="(ll, index) in landlines" :key="index">
                                <div class="flex gap-3">
                                    <input type="text" name="landlines[]" x-model="landlines[index]" class="flex-1 px-6 py-3 bg-slate-50 rounded-xl text-xs font-bold outline-none border border-transparent focus:bg-white focus:border-[#0F4A3B]/10" placeholder="Landline number...">
                                    <button type="button" @click="removeLandline(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                </div>
                            </template>
                        </div>

                        <!-- Emails -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Support Emails</label>
                                <button type="button" @click="addEmail()" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">+ Add Email</button>
                            </div>
                            <template x-for="(email, index) in emails" :key="index">
                                <div class="flex gap-3">
                                    <input type="email" name="emails[]" x-model="emails[index]" class="flex-1 px-6 py-3 bg-slate-50 rounded-xl text-xs font-bold outline-none border border-transparent focus:bg-white focus:border-[#0F4A3B]/10" placeholder="support@figoholidays.com">
                                    <button type="button" @click="removeEmail(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                </div>
                            </template>
                        </div>

                        <!-- Map URLs -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Google Map URLs</label>
                                <button type="button" @click="addMapUrl()" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">+ Add Map</button>
                            </div>
                            <template x-for="(url, index) in mapUrls" :key="index">
                                <div class="flex gap-3">
                                    <input type="url" name="map_urls[]" x-model="mapUrls[index]" class="flex-1 px-6 py-3 bg-slate-50 rounded-xl text-xs font-bold outline-none border border-transparent focus:bg-white focus:border-[#0F4A3B]/10" placeholder="https://maps.google.com/...">
                                    <button type="button" @click="removeMapUrl(index)" class="p-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-all">&times;</button>
                                </div>
                            </template>
                        </div>

                        <div class="space-y-2 lg:col-span-2 pt-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Copyright Text</label>
                            <input type="text" name="copyright_text" value="{{ $settings->copyright_text }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Home Customization Section -->
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8 lg:col-span-2">
                    <div class="flex items-center gap-3 border-b border-slate-50 pb-6">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Homepage Stats & Customization</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                        <div class="space-y-4 text-center p-8 bg-slate-50 rounded-[2rem]">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Experience Years</label>
                            <input type="number" name="experience_count" value="{{ $settings->experience_count }}" class="w-full text-center bg-transparent text-3xl font-black text-[#0F4A3B] outline-none">
                            <p class="text-[10px] font-bold text-slate-400">Numerical Input</p>
                        </div>
                        <div class="space-y-4 text-center p-8 bg-slate-50 rounded-[2rem]">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Destinations</label>
                            <input type="number" name="destination_count" value="{{ $settings->destination_count }}" class="w-full text-center bg-transparent text-3xl font-black text-[#0F4A3B] outline-none">
                            <p class="text-[10px] font-bold text-slate-400">Locations Covered</p>
                        </div>
                        <div class="space-y-4 text-center p-8 bg-slate-50 rounded-[2rem]">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Gulf Customers</label>
                            <input type="number" name="customers_count" value="{{ $settings->customers_count }}" class="w-full text-center bg-transparent text-3xl font-black text-[#0F4A3B] outline-none">
                            <p class="text-[10px] font-bold text-slate-400">Happy Clients</p>
                        </div>
                        <div class="space-y-4 text-center p-8 bg-slate-50 rounded-[2rem]">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Trips Completed</label>
                            <input type="number" name="trip_count" value="{{ $settings->trip_count }}" class="w-full text-center bg-transparent text-3xl font-black text-[#0F4A3B] outline-none">
                            <p class="text-[10px] font-bold text-slate-400">Successful Journeys</p>
                        </div>

                        <div class="space-y-4 text-center p-8 bg-slate-50 rounded-[2rem]">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Panel Theme Color</label>
                            <div class="flex items-center justify-center gap-4">
                                <input type="color" name="primary_color" value="{{ $settings->primary_color ?? '#0F4A3B' }}" class="w-12 h-12 rounded-xl cursor-pointer border-none bg-transparent">
                                <input type="text" value="{{ $settings->primary_color ?? '#0F4A3B' }}" class="text-xl font-black text-[#0F4A3B] bg-transparent w-24 outline-none" readonly>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400">Choose Primary Color</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="px-20 py-5 bg-[#0F4A3B] text-white rounded-[2rem] font-black shadow-2xl shadow-[#0F4A3B]/30 hover:scale-105 active:scale-95 transition-all text-lg">
                    Save Global Settings
                </button>
            </div>
        </form>
    </div>

    <script>
        function settingsManager() {
            return {
                logoPreview: null,
                footerLogoPreview: null,
                headOffices: {!! json_encode($settings->head_offices ?? ['']) !!},
                whatsapps: {!! json_encode($settings->whatsapps ?? ['']) !!},
                landlines: {!! json_encode($settings->landlines ?? ['']) !!},
                emails: {!! json_encode($settings->emails ?? ['']) !!},
                mapUrls: {!! json_encode($settings->map_urls ?? ['']) !!},

                previewLogo(e) {
                    const file = e.target.files[0];
                    if (file) this.logoPreview = URL.createObjectURL(file);
                },
                previewFooterLogo(e) {
                    const file = e.target.files[0];
                    if (file) this.footerLogoPreview = URL.createObjectURL(file);
                },

                addOffice() { this.headOffices.push(''); },
                removeOffice(index) { this.headOffices.splice(index, 1); },

                addWhatsapp() { this.whatsapps.push(''); },
                removeWhatsapp(index) { this.whatsapps.splice(index, 1); },

                addLandline() { this.landlines.push(''); },
                removeLandline(index) { this.landlines.splice(index, 1); },

                addEmail() { this.emails.push(''); },
                removeEmail(index) { this.emails.splice(index, 1); },

                addMapUrl() { this.mapUrls.push(''); },
                removeMapUrl(index) { this.mapUrls.splice(index, 1); }
            }
        }
    </script>
</x-app-layout>
