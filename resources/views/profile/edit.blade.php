<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700 pb-20">
        <!-- Header -->
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Your Profile</h1>
            <p class="text-slate-400 mt-2 font-semibold">Update your personal information and security settings.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            @method('PUT')

            <!-- Left Col: Personal Details -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="flex items-center gap-3 border-b border-slate-50 pb-6">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Personal Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mobile Number</label>
                            <input type="text" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="flex items-center gap-3 border-b border-slate-50 pb-6">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <h2 class="text-xl font-black text-slate-900">Security / Change Password</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">New Password</label>
                            <input type="password" name="password" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all" placeholder="Leave blank to keep current">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 outline-none transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Info/Actions -->
            <div class="space-y-10">
                <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm p-10 space-y-8">
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full bg-[#0F4A3B] mx-auto flex items-center justify-center text-white text-4xl font-black mb-4">
                            {{ substr($user->first_name ?: $user->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-black text-slate-900">{{ $user->name }}</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Administrator Account</p>
                    </div>

                    <div class="pt-6 border-t border-slate-50 space-y-4">
                        <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
