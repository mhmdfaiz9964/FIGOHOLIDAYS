<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-6 lg:p-10">
        <!-- Main Card -->
        <div class="w-full max-w-5xl bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[700px]">
            
            <!-- Information Side -->
            <div class="lg:w-1/2 bg-[#0F4A3B] p-12 lg:p-16 flex flex-col justify-between relative overflow-hidden">
                <!-- Abstract Background Shapes -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="p-2 bg-white/10 rounded-xl backdrop-blur-md">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-black text-white tracking-tight">FIGO <span class="text-emerald-400/80">HOLIDAYS</span></h1>
                    </div>

                    <div class="space-y-6">
                        <h2 class="text-5xl font-black text-white leading-tight">Admin <br>Command <span class="text-emerald-400">Center</span></h2>
                        <p class="text-emerald-50/60 text-lg font-medium max-w-sm">Manage your premium travel packages, visa consultations, and guest experiences from one powerful interface.</p>
                    </div>
                </div>

                <div class="relative z-10 pt-10 border-t border-white/10">
                    <p class="text-white/40 text-xs font-bold uppercase tracking-widest">Powered by Apex Web Innovation</p>
                </div>
            </div>

            <div class="lg:w-1/2 p-12 lg:p-20 flex flex-col justify-center bg-white" x-data="{ showPassword: false }">
                <div class="mb-12">
                    <h3 class="text-3xl font-black text-slate-900 mb-2">Welcome Back</h3>
                    <p class="text-slate-400 font-semibold">Please enter your credentials to access the console.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-1">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </span>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                                   class="w-full pl-14 pr-6 py-4 bg-slate-50 border-transparent rounded-[1.25rem] font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="admin@figoholidays.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-1">
                            <label for="password" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Secret Password</label>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </span>
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" 
                                   class="w-full pl-14 pr-14 py-4 bg-slate-50 border-transparent rounded-[1.25rem] font-bold text-slate-900 focus:bg-white focus:border-[#0F4A3B]/20 focus:ring-4 focus:ring-[#0F4A3B]/5 transition-all outline-none" placeholder="••••••••">
                            
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-[#0F4A3B] transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2 px-1">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded text-[#0F4A3B] focus:ring-[#0F4A3B] border-slate-200">
                        <label for="remember_me" class="text-xs font-bold text-slate-500 cursor-pointer">Stay logged in on this session</label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-[#0F4A3B] text-white rounded-[1.25rem] font-black shadow-xl shadow-[#0F4A3B]/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                            <span>Access Console</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
