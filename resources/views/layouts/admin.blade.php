<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - Rodeo Laundry Malang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-[#EEF1F8] text-[#1A1743] antialiased min-h-screen selection:bg-[#BFF108] selection:text-[#1E1B4B]">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        <!-- ================= SIDEBAR ================= -->
        <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white/95 backdrop-blur-md border-r border-slate-300/80 shadow-[4px_0_24px_rgba(26,23,67,0.04)] flex flex-col justify-between transition-transform duration-300 transform md:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            
            <div>
                <!-- Brand Logo -->
                <div class="h-20 px-6 flex items-center gap-3 border-b border-slate-200/80">
                    <div class="w-10 h-10 rounded-xl bg-[#1E1B4B] flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-[#BFF108]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <circle cx="12" cy="12" r="3" fill="#BFF108"/>
                            <path d="M12 3v3m0 12v3M3 12h3m12 0h3"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-extrabold text-[#1E1B4B] tracking-tight">
                            Rodeo<span class="text-[#BFF108]">.</span><span class="text-[#64748B] font-semibold text-sm">Laundry</span>
                        </div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-[#94A3B8]">Admin Portal</div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5 font-medium text-sm">
                    @php
                        $currentRoute = request()->route()->getName();
                    @endphp

                    <!-- 1. Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1E1B4B] text-white font-bold shadow-md shadow-[#1E1B4B]/20' : 'text-slate-600 hover:bg-slate-100 hover:text-[#1E1B4B]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="w-2.5 h-2.5 rounded-full bg-[#BFF108] ring-4 ring-[#BFF108]/20"></span>
                        @endif
                    </a>

                    <!-- 2. POS / Kasir -->
                    <a href="{{ route('admin.pos') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.pos*') ? 'bg-[#1E1B4B] text-white font-bold shadow-md shadow-[#1E1B4B]/20' : 'text-slate-600 hover:bg-slate-100 hover:text-[#1E1B4B]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <span>POS / Kasir</span>
                        </div>
                        @if(request()->routeIs('admin.pos*'))
                            <span class="w-2.5 h-2.5 rounded-full bg-[#BFF108] ring-4 ring-[#BFF108]/20"></span>
                        @endif
                    </a>

                    <!-- 3. Pelanggan -->
                    <a href="{{ route('admin.customers.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.customers*') ? 'bg-[#1E1B4B] text-white font-bold shadow-md shadow-[#1E1B4B]/20' : 'text-slate-600 hover:bg-slate-100 hover:text-[#1E1B4B]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Pelanggan</span>
                        </div>
                        @if(request()->routeIs('admin.customers*'))
                            <span class="w-2.5 h-2.5 rounded-full bg-[#BFF108] ring-4 ring-[#BFF108]/20"></span>
                        @endif
                    </a>

                    <!-- 4. Layanan -->
                    <a href="{{ route('admin.services.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.services*') ? 'bg-[#1E1B4B] text-white font-bold shadow-md shadow-[#1E1B4B]/20' : 'text-slate-600 hover:bg-slate-100 hover:text-[#1E1B4B]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span>Layanan</span>
                        </div>
                        @if(request()->routeIs('admin.services*'))
                            <span class="w-2.5 h-2.5 rounded-full bg-[#BFF108] ring-4 ring-[#BFF108]/20"></span>
                        @endif
                    </a>

                    <!-- 5. Pembayaran -->
                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.payments*') ? 'bg-[#1E1B4B] text-white font-bold shadow-md shadow-[#1E1B4B]/20' : 'text-slate-600 hover:bg-slate-100 hover:text-[#1E1B4B]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span>Pembayaran</span>
                        </div>
                        @if(request()->routeIs('admin.payments*'))
                            <span class="w-2.5 h-2.5 rounded-full bg-[#BFF108] ring-4 ring-[#BFF108]/20"></span>
                        @endif
                    </a>

                    <!-- 6. Pengiriman -->
                    <a href="{{ route('admin.deliveries.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('admin.deliveries*') ? 'bg-[#1E1B4B] text-white font-bold shadow-md shadow-[#1E1B4B]/20' : 'text-slate-600 hover:bg-slate-100 hover:text-[#1E1B4B]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                            <span>Pengiriman</span>
                        </div>
                        @if(request()->routeIs('admin.deliveries*'))
                            <span class="w-2.5 h-2.5 rounded-full bg-[#BFF108] ring-4 ring-[#BFF108]/20"></span>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- Bottom Profile Card -->
            <div class="p-4 border-t border-slate-200/80">
                <div class="bg-slate-100/90 border border-slate-200/80 rounded-2xl p-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-[#1E1B4B] text-white font-bold flex items-center justify-center text-sm shadow">
                                R
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-[#BFF108] border-2 border-white rounded-full"></span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-[#1E1B4B] leading-tight">Admin Rodeo</div>
                            <div class="text-[11px] text-[#64748B]">Cabang Malang</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" class="p-2 text-[#64748B] hover:text-red-500 hover:bg-white rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Backdrop for mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm md:hidden"></div>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="flex-1 flex flex-col md:pl-64 min-w-0">

            <!-- ================= TOPBAR ================= -->
            <header class="h-20 bg-white/95 backdrop-blur-md border-b border-slate-300/80 shadow-xs sticky top-0 z-20 px-6 md:px-8 flex items-center justify-between gap-4">
                
                <!-- Left: Hamburger (mobile) + Search Bar -->
                <div class="flex items-center gap-3 flex-1 max-w-xl">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-xl text-[#1E1B4B] hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Global Search -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="relative w-full max-w-md hidden sm:block">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nota, nomor rak, pelanggan..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-100/90 border border-slate-300/80 rounded-full text-xs md:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1E1B4B] focus:ring-2 focus:ring-[#1E1B4B]/15 transition">
                    </form>
                </div>

                <!-- Right Controls -->
                <div class="flex items-center gap-2 md:gap-3">
                    
                    <!-- Date Pill & Picker -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="relative flex items-center">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <label class="relative flex items-center gap-2 px-4 py-2 bg-slate-100/90 hover:bg-white border border-slate-300/80 rounded-full text-xs font-bold text-slate-800 shadow-xs cursor-pointer transition" title="Klik untuk pilih tanggal & filter pendapatan">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>
                                @if(request('date'))
                                    {{ \Carbon\Carbon::parse(request('date'))->isoFormat('D MMM Y') }}
                                @else
                                    Hari Ini: {{ \Carbon\Carbon::now()->isoFormat('D MMM Y') }}
                                @endif
                            </span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <input type="date"
                                   name="date"
                                   value="{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                   onchange="this.form.submit()"
                                   class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                        </label>
                    </form>

                    <!-- Notification Bell -->
                    <button class="relative w-10 h-10 rounded-full bg-slate-100/90 hover:bg-white border border-slate-300/80 flex items-center justify-center text-slate-700 hover:text-[#1E1B4B] transition shadow-xs">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>
                </div>
            </header>

            <!-- ================= FLASH MESSAGES ================= -->
            @if(session('success'))
                <div class="mx-6 md:mx-8 mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between"
                     x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-900">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 md:mx-8 mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between"
                     x-data="{ show: true }" x-show="show">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-600 hover:text-rose-900">&times;</button>
                </div>
            @endif

            <!-- ================= BODY CONTENT ================= -->
            <main class="flex-1 p-6 md:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
