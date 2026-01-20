<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8F9FA]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FIGO HOLIDAYS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @php 
            $siteSettings = \App\Models\GeneralSetting::first();
            $primaryColor = $siteSettings->primary_color ?? '#0F4A3B';
        @endphp
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                green: '{{ $primaryColor }}',
                                greenLight: '{{ $primaryColor }}CC', // Added transparency
                            }
                        }
                    }
                }
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: {{ $primaryColor }};
            }
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                margin: 0;
                padding: 0;
            }
            [x-cloak] { display: none !important; }
            
            /* Dynamic Color Overrides */
            .bg-\[\#0F4A3B\] { background-color: var(--primary-color) !important; }
            .text-\[\#0F4A3B\] { color: var(--primary-color) !important; }
            .border-\[\#0F4A3B\] { border-color: var(--primary-color) !important; }
            .shadow-\[\#0F4A3B\/20\] { --tw-shadow-color: {{ $primaryColor }}33; }
            .hover\:text-\[\#0F4A3B\]:hover { color: var(--primary-color) !important; }
            .hover\:bg-\[\#0F4A3B\]:hover { background-color: var(--primary-color) !important; }
            .focus\:border-\[\#0F4A3B\/20\]:focus { border-color: {{ $primaryColor }}33 !important; }
            .active-nav-item {
                background-color: var(--primary-color) !important;
                color: white !important;
            }
            
            /* Robust Layout Fallback */
            .layout-wrapper {
                display: flex;
                height: 100vh;
                overflow: hidden;
            }
            .sidebar-robust {
                width: 280px;
                flex-shrink: 0;
                background: white;
                border-right: 1px solid #f1f5f9;
                display: flex;
                flex-direction: column;
            }
            .main-content-robust {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-width: 0;
                overflow: hidden;
                background-color: #F8F9FA;
            }
            .content-scrollable {
                flex: 1;
                overflow-y: auto;
                padding: 2rem;
            }
            
            .active-nav-item {
                background-color: #0F4A3B !important;
                color: white !important;
            }
            .stat-card-green {
                background: linear-gradient(135deg, #0F4A3B 0%, #1A6B56 100%);
            }
        </style>
    </head>
    <body class="antialiased text-slate-900" x-data="{ sidebarOpen: false }">
        <div class="layout-wrapper">
            <!-- Sidebar -->
            <div class="sidebar-robust" :class="sidebarOpen ? 'block' : 'hidden lg:flex'">
                @include('layouts.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="main-content-robust">
                <!-- Top Header -->
                <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-slate-50 lg:bg-transparent lg:border-none">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md hidden lg:block">
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Search task" class="w-full pl-11 pr-12 py-2.5 bg-white border border-slate-100 rounded-2xl text-sm focus:ring-4 focus:ring-[#0F4A3B]/5 focus:border-slate-200 transition-all shadow-sm">
                        </div>
                    </div>

                    <!-- Mobile Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Right Icons -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <button class="p-2.5 bg-white border border-slate-100 rounded-full text-slate-400 hover:text-[#0F4A3B] transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </button>
                            <button class="p-2.5 bg-white border border-slate-100 rounded-full text-slate-400 hover:text-[#0F4A3B] transition-colors shadow-sm relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-2.5 right-2.5 w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                            </button>
                        </div>
                        <div class="relative" x-data="{ profileOpen: false }">
                            <div @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-3 pl-2 group cursor-pointer hover:opacity-80 transition-all">
                                <div class="w-10 h-10 rounded-full bg-[#0F4A3B] flex items-center justify-center text-white font-bold shadow-lg shadow-[#0F4A3B]/20">
                                    {{ substr(Auth::user()->first_name ?: Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Admin</p>
                                        <svg class="w-3 h-3 text-slate-300 transition-transform" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Dropdown Menu -->
                            <div x-show="profileOpen" x-cloak 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                 class="absolute right-0 mt-4 w-56 bg-white rounded-3xl shadow-2xl border border-slate-50 overflow-hidden z-50">
                                <div class="p-4 border-b border-slate-50 bg-slate-50/50">
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 font-bold text-sm hover:bg-slate-50 hover:text-[#0F4A3B] transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        Your Profile
                                    </a>
                                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 font-bold text-sm hover:bg-slate-50 hover:text-[#0F4A3B] transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        Site Settings
                                    </a>
                                </div>
                                <div class="p-2 border-t border-slate-50">
                                    <button @click="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-rose-600 font-bold text-sm hover:bg-rose-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="content-scrollable">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif

            function confirmDelete(id, text = "This action cannot be undone!") {
                Swal.fire({
                    title: 'Are you sure?',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0F4A3B',
                    cancelButtonColor: '#f43f5e',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
            }

            function confirmLogout() {
                Swal.fire({
                    title: 'Logout?',
                    text: "Are you sure you want to end your session?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0F4A3B',
                    cancelButtonColor: '#f43f5e',
                    confirmButtonText: 'Yes, Logout',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-10 py-3 font-black text-xs uppercase tracking-widest',
                        cancelButton: 'rounded-xl px-10 py-3 font-black text-xs uppercase tracking-widest'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('logout') }}';
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        document.body.appendChild(form);
                        form.submit();
                    }
                })
            }
        </script>
    </body>
</html>
