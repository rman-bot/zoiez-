<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Zoiez Motor</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        @media print {
            html, body {
                height: auto !important;
                overflow: visible !important;
                background-color: #ffffff !important;
                color: #000000 !important;
            }
            body > div {
                display: block !important;
                height: auto !important;
                overflow: visible !important;
            }
            .hidden.md\:flex.md\:flex-shrink-0,
            .md\:hidden.flex.items-center.justify-between.h-16.bg-slate-900,
            header,
            .print\:hidden {
                display: none !important;
            }
            main {
                display: block !important;
                width: 100% !important;
                height: auto !important;
                overflow: visible !important;
                position: static !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .py-6, .px-4, .md\:py-8, .md\:px-8 {
                padding: 0 !important;
            }
            tr {
                page-break-inside: avoid !important;
            }
            thead {
                display: table-header-group !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="h-full flex overflow-hidden">
    <!-- Sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="flex flex-col h-0 flex-1 bg-slate-900">
                <!-- Brand logo -->
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-slate-950 gap-3">
                    <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 text-white shadow-md shadow-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-white tracking-wider">Zoiez Motor</span>
                </div>
                
                <!-- Navigation Menu -->
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Kategori -->
                        <a href="{{ route('kategori.index') }}" 
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('kategori.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('kategori.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Kategori
                        </a>

                        <!-- Spareparts -->
                        <a href="{{ route('sparepart.index') }}" 
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('sparepart.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('sparepart.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Data Sparepart
                            @php
                                $criticalCount = \App\Models\Sparepart::whereColumn('stok', '<=', 'stok_minimal')->count();
                            @endphp
                            @if($criticalCount > 0)
                                <span class="ml-auto inline-block py-0.5 px-2 text-xs font-bold rounded-full bg-red-500/20 text-red-400">
                                    {{ $criticalCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Barang Masuk -->
                        <a href="{{ route('barang-masuk.index') }}" 
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('barang-masuk.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('barang-masuk.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Barang Masuk
                        </a>

                        <!-- Barang Keluar -->
                        <a href="{{ route('barang-keluar.index') }}" 
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('barang-keluar.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('barang-keluar.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Barang Keluar
                        </a>

                        <!-- Laporan -->
                        <a href="{{ route('laporan.index') }}" 
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-150 {{ request()->routeIs('laporan.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 {{ request()->routeIs('laporan.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Laporan Transaksi
                        </a>
                    </nav>
                </div>

                <!-- User Profile & Logout -->
                <div class="flex-shrink-0 flex bg-slate-950 p-4 border-t border-slate-800">
                    <div class="flex items-center w-full justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center shadow-md">
                                A
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-white leading-none">{{ Auth::user()->name }}</p>
                                <span class="text-xs text-slate-500">Administrator</span>
                            </div>
                        </div>
                        <a href="{{ route('logout') }}" 
                            class="text-slate-500 hover:text-red-400 p-2 rounded-lg hover:bg-slate-800/40 transition-colors"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            title="Keluar dari Sistem">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <!-- Top bar for mobile -->
        <div class="md:hidden flex items-center justify-between h-16 bg-slate-900 px-4 flex-shrink-0 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                </div>
                <span class="text-md font-bold text-white tracking-wide">Zoiez Motor</span>
            </div>
            <!-- Mobile Menu Dropdown Toggle (using simple details tag for no-js interactive toggle) -->
            <details class="relative">
                <summary class="list-none focus:outline-none p-2 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-colors cursor-pointer">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </summary>
                <div class="absolute right-0 mt-2 w-48 bg-slate-900 border border-slate-800 rounded-xl shadow-xl z-50 p-2 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg">Dashboard</a>
                    <a href="{{ route('kategori.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg">Kategori</a>
                    <a href="{{ route('sparepart.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg flex justify-between">
                        <span>Sparepart</span>
                        @if($criticalCount > 0)
                            <span class="inline-block py-0.5 px-1.5 text-2xs font-bold rounded-full bg-red-500/20 text-red-400">{{ $criticalCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('barang-masuk.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg">Barang Masuk</a>
                    <a href="{{ route('barang-keluar.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg">Barang Keluar</a>
                    <a href="{{ route('laporan.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg">Laporan</a>
                    <hr class="border-slate-800 my-1">
                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 rounded-lg">Keluar</a>
                </div>
            </details>
        </div>

        <!-- Main Workspace -->
        <main class="flex-1 overflow-y-auto relative focus:outline-none bg-slate-50">
            <!-- Header bar for desktop -->
            <header class="hidden md:flex justify-between items-center h-16 bg-white border-b border-slate-200 px-8 flex-shrink-0">
                <h2 class="text-xl font-bold text-slate-800">@yield('page-title')</h2>
                <div class="flex items-center gap-4 text-sm text-slate-500 font-medium">
                    <span>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
            </header>

            <div class="py-6 px-4 md:py-8 md:px-8">
                <!-- Notifications / Flash Alerts -->
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-500 text-white shadow-md shadow-emerald-500/20 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-semibold text-emerald-900">Berhasil!</span>
                            <p class="text-slate-600 mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-rose-500 text-white shadow-md shadow-rose-500/20 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-semibold text-rose-900">Gagal!</span>
                            <p class="text-slate-600 mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start gap-3 shadow-sm animate-fade-in">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-rose-500 text-white shadow-md shadow-rose-500/20 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </span>
                        <div>
                            <span class="font-semibold text-rose-900">Harap periksa form pengisian:</span>
                            <ul class="list-disc list-inside mt-1 text-slate-600 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
