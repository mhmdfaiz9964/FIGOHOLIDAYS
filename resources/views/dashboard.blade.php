<x-app-layout>
    <div class="space-y-10 animate-in fade-in duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Dashboard</h1>
                <p class="text-slate-400 mt-2 font-semibold">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-6 py-3.5 bg-white border border-slate-100 rounded-2xl font-bold text-sm text-slate-900 shadow-sm">
                    {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
            <!-- Offers -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all group">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" /></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['offers'] }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Total Offers</p>
            </div>

            <!-- Hotels -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 transition-all group">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['hotels'] }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Hotels Listed</p>
            </div>

            <!-- Destinations -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-sm hover:shadow-xl hover:shadow-amber-500/5 transition-all group">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['destinations'] }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Destinations</p>
            </div>

            <!-- Reviews -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-sm hover:shadow-xl hover:shadow-rose-500/5 transition-all group">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['reviews'] }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Reviews</p>
            </div>

            <!-- Partners -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['partners'] }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Partners</p>
            </div>

            <!-- Restaurants -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-50 shadow-sm hover:shadow-xl hover:shadow-purple-500/5 transition-all group">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900">{{ $stats['restaurants'] }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Restaurants</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Recent Offers -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between">
                    <h2 class="text-xl font-black text-slate-900">Recent Offers</h2>
                    <a href="{{ route('offers.index') }}" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">View All</a>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <th class="px-6 py-4">Title</th>
                                    <th class="px-6 py-4">Category</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($recentOffers as $offer)
                                    <tr class="group hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-700 text-sm">{{ $offer->title }}</td>
                                        <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $offer->offerCategory->name }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('offers.edit', $offer) }}" class="text-[#0F4A3B] hover:opacity-70">
                                                <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Latest Reviews -->
            <div class="bg-white rounded-[2.5rem] border border-slate-50 shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between">
                    <h2 class="text-xl font-black text-slate-900">Latest Reviews</h2>
                    <a href="{{ route('reviews.index') }}" class="text-[10px] font-black text-[#0F4A3B] uppercase tracking-widest hover:opacity-70">View All</a>
                </div>
                <div class="p-6 space-y-6">
                    @foreach($recentReviews as $review)
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                @if($review->user_image)
                                    <img src="{{ Storage::url($review->user_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center font-black text-slate-400 text-sm uppercase">
                                        {{ substr($review->user_name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-slate-900 truncate text-sm">{{ $review->user_name }}</h4>
                                    <div class="flex text-amber-400">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-xs text-slate-400 line-clamp-2 italic font-medium">"{{ $review->description }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
