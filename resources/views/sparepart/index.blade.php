@extends('layouts.app')

@section('title', 'Data Sparepart')
@section('page-title', 'Daftar Sparepart')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Action Bar & Filter Form -->
    <div class="flex flex-col gap-5">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Kelola data master sparepart bengkel, pantau ketersediaan stok, dan lakukan transaksi.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('sparepart.create') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Sparepart
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white border border-slate-150 rounded-2xl shadow-sm p-4 md:p-6">
            <form action="{{ route('sparepart.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Search input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Cari Sparepart</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all"
                            placeholder="Ketik kode, nama, atau merk...">
                    </div>
                </div>

                <!-- Category selection -->
                <div>
                    <label for="kategori_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Filter Kategori</label>
                    <select name="kategori_id" id="kategori_id"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('kategori_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="flex gap-2">
                    <button type="submit" 
                        class="flex-1 justify-center inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 active:bg-slate-900 rounded-xl transition-all">
                        Filter
                    </button>
                    @if(request('search') || request('kategori_id'))
                        <a href="{{ route('sparepart.index') }}" 
                            class="inline-flex items-center justify-center p-2.5 text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all"
                            title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H19" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($spareparts->count() > 0)
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th scope="col" class="px-6 py-4 text-left rounded-l-lg">Kode</th>
                            <th scope="col" class="px-6 py-4 text-left">Nama / Merek</th>
                            <th scope="col" class="px-6 py-4 text-left">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-right">Harga Beli</th>
                            <th scope="col" class="px-6 py-4 text-right">Harga Jual</th>
                            <th scope="col" class="px-6 py-4 text-center">Stok</th>
                            <th scope="col" class="px-6 py-4 text-center">Stok Min</th>
                            <th scope="col" class="px-6 py-4 text-center rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($spareparts as $part)
                            @php
                                // Color logic for stock level
                                if ($part->stok == 0 || $part->isStokMenipis()) {
                                    $stockBg = 'bg-rose-500/10 text-rose-600 border border-rose-500/20';
                                    $stockRow = 'bg-rose-50/10';
                                    $stockBadgeText = 'Kritis / Menipis';
                                } elseif ($part->stok <= $part->stok_minimal * 1.5) {
                                    $stockBg = 'bg-amber-500/10 text-amber-600 border border-amber-500/20';
                                    $stockRow = '';
                                    $stockBadgeText = 'Mendekati Batas';
                                } else {
                                    $stockBg = 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20';
                                    $stockRow = '';
                                    $stockBadgeText = 'Aman';
                                }
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors {{ $stockRow }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">{{ $part->kode_sparepart }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900">{{ $part->nama_sparepart }}</div>
                                    <div class="text-xs text-slate-400 font-medium">Merk: {{ $part->merk ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $part->kategori->nama_kategori }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-right font-medium">
                                    Rp {{ number_format($part->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-950 text-right font-semibold">
                                    Rp {{ number_format($part->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="px-2.5 py-1 text-xs rounded-lg font-bold {{ $stockBg }}">
                                            {{ $part->stok }} {{ $part->satuan }}
                                        </span>
                                        <span class="text-2xs text-slate-400 mt-1 uppercase font-semibold">{{ $stockBadgeText }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-500">{{ $part->stok_minimal }} {{ $part->satuan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Restok button (Barang Masuk) -->
                                        <a href="{{ route('barang-masuk.create', ['sparepart_id' => $part->id]) }}" 
                                            class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"
                                            title="Catat Barang Masuk (Restok)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </a>

                                        <!-- Keluar button (Barang Keluar) -->
                                        <a href="{{ route('barang-keluar.create', ['sparepart_id' => $part->id]) }}" 
                                            class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-all"
                                            title="Catat Barang Keluar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </a>
                                        
                                        <!-- Edit button -->
                                        <a href="{{ route('sparepart.edit', $part->id) }}" 
                                            class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                            title="Ubah">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        
                                        <!-- Delete button -->
                                        <form action="{{ route('sparepart.destroy', $part->id) }}" method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sparepart ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all"
                                                title="Hapus"
                                                {{ ($part->barangMasuk()->count() > 0 || $part->barangKeluar()->count() > 0) ? 'disabled style=opacity:0.3;cursor:not-allowed;' : '' }}>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <span class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4 shadow-inner">
                        <!-- Spareparts Empty SVG -->
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Sparepart Tidak Ditemukan</h3>
                    <p class="text-sm text-slate-500 max-w-xs mt-1">Belum ada sparepart terdaftar yang cocok dengan kriteria pencarian Anda.</p>
                    <div class="flex items-center gap-3 mt-4">
                        <a href="{{ route('sparepart.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                            Tambah Sparepart
                        </a>
                        @if(request('search') || request('kategori_id'))
                            <a href="{{ route('sparepart.index') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
