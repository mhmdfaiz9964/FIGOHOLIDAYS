<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header Section -->
        <div class="flex items-center gap-6">
            <a href="{{ route('users.index') }}" class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-[#0F4A3B] transition-all shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Edit User</h1>
                <p class="text-slate-400 mt-2 font-semibold">Update account details for {{ $user->first_name }}.</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden">
            <form action="{{ route('users.update', $user) }}" method="POST" class="p-10 space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <label for="first_name" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Enter first name">
                        @error('first_name') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <label for="last_name" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Enter last name">
                        @error('last_name') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Username -->
                    <div class="space-y-2">
                        <label for="username" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Choose a username">
                        @error('username') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="name@example.com">
                        @error('email') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Mobile Number -->
                    <div class="space-y-2">
                        <label for="mobile_number" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" required
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="+1 (000) 000-0000">
                        @error('mobile_number') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Account Status</label>
                        <select name="status" id="status" required
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none appearance-none">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">New Password (Optional)</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Leave blank to keep current">
                        @error('password') <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest px-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-6 py-4 bg-slate-50 border border-transparent rounded-2xl text-slate-900 font-bold focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="Confirm new password">
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50 flex justify-end gap-4">
                    <a href="{{ route('users.index') }}" class="px-8 py-4 bg-slate-50 text-slate-400 rounded-2xl font-bold hover:bg-slate-100 transition-all">Cancel</a>
                    <button type="submit" class="px-10 py-4 bg-[#0F4A3B] text-white rounded-2xl font-black shadow-xl shadow-[#0F4A3B]/20 hover:opacity-90 transition-all">
                        Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
