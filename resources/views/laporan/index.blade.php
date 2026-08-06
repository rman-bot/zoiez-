@extends('layouts.app')

@section('title', 'Laporan Keuangan & Transaksi')
@section('page-title', 'Laporan Keuangan & Transaksi')

@section('content')
<style>
@media print {
    @page {
        margin: 1.5cm 1.2cm 1.5cm 1.2cm;
        size: A4 portrait;
    }
    .grid {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        gap: 12px !important;
    }
    /* Style cards for print */
    .bg-white, .bg-slate-50\/50, .bg-rose-50\/50, .bg-emerald-50\/50 {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
    }
    /* Valuasi Aset styling override for print */
    .bg-slate-900 {
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
    }
    .bg-slate-900 *, .bg-slate-900 h3 {
        color: #0f172a !important;
    }
    /* Table borders & padding */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-top: 15px !important;
    }
    th, td {
        border: 1px solid #e2e8f0 !important;
        padding: 8px 10px !important;
        font-size: 11px !important;
        line-height: 1.4 !important;
    }
    thead th {
        background-color: #f1f5f9 !important;
        color: #1e293b !important;
        font-weight: 700 !important;
    }
    /* Prevent row split across pages */
    tr {
        page-break-inside: avoid !important;
    }
}
</style>

<div class="space-y-6 animate-fade-in">

    <!-- Action Bar & Filter Form -->
    <div class="flex flex-col gap-5 print:hidden">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Analisis keuangan, perputaran barang, Harga Pokok Penjualan (HPP), dan valuasi aset secara akurat.</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Unduh PDF (DomPDF) -->
                <a href="{{ route('laporan.index', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-sm transition-all">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M5 20h14a2 2 0 002-2V8l-6-6H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Unduh PDF
                </a>
                
                <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 active:bg-slate-100 border border-slate-200 rounded-xl shadow-sm transition-all">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Halaman
                </button>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white border border-slate-150 rounded-2xl shadow-sm p-4 md:p-6">
            <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Start Date -->
                <div>
                    <label for="tanggal_mulai" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ $startDate }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- End Date -->
                <div>
                    <label for="tanggal_selesai" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ $endDate }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Transaction Type -->
                <div>
                    <label for="jenis_transaksi" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Jenis Transaksi</label>
                    <select name="jenis_transaksi" id="jenis_transaksi"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                        <option value="Semua" {{ $type === 'Semua' ? 'selected' : '' }}>Semua Transaksi</option>
                        <option value="Masuk" {{ $type === 'Masuk' ? 'selected' : '' }}>Barang Masuk (Restok)</option>
                        <option value="Keluar" {{ $type === 'Keluar' ? 'selected' : '' }}>Barang Keluar (Terjual)</option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="flex gap-2">
                    <button type="submit" 
                        class="flex-1 justify-center inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 active:bg-slate-900 rounded-xl transition-all">
                        Tampilkan
                    </button>
                    <a href="{{ route('laporan.index') }}" 
                        class="inline-flex items-center justify-center p-2.5 text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all"
                        title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H19" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>

    </div>

    <!-- Financial Performance Cards (Accounting Metrics) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 print:grid-cols-4">
        <!-- Total Pembelian -->
        <div class="bg-white border border-slate-150 p-5 rounded-2xl shadow-sm flex flex-col justify-between print:border-slate-300">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pembelian (Restok)</span>
            <div class="mt-2">
                <span class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</span>
                <p class="text-[10px] text-slate-400 mt-1 print:hidden">Pengeluaran kas untuk stok masuk dalam periode ini.</p>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="bg-white border border-slate-150 p-5 rounded-2xl shadow-sm flex flex-col justify-between print:border-slate-300">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Penjualan</span>
            <div class="mt-2">
                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</span>
                <p class="text-[10px] text-slate-400 mt-1 print:hidden">Nilai transaksi barang keluar berdasarkan harga jual master.</p>
            </div>
        </div>

        <!-- HPP -->
        <div class="bg-white border border-slate-150 p-5 rounded-2xl shadow-sm flex flex-col justify-between print:border-slate-300">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Harga Pokok Penjualan (HPP)</span>
            <div class="mt-2">
                <span class="text-2xl font-bold text-amber-600">Rp {{ number_format($totalHpp, 0, ',', '.') }}</span>
                <p class="text-[10px] text-slate-400 mt-1 print:hidden">Harga modal beli barang yang keluar dalam periode ini.</p>
            </div>
        </div>

        <!-- Laba Kotor -->
        <div class="bg-white border border-slate-150 p-5 rounded-2xl shadow-sm flex flex-col justify-between print:border-slate-300 {{ $labaKotor >= 0 ? 'bg-emerald-50/50 border-emerald-100' : 'bg-rose-50/50 border-rose-100' }}">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estimasi Laba Kotor</span>
            <div class="mt-2">
                <span class="text-2xl font-bold {{ $labaKotor >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </span>
                <p class="text-[10px] text-slate-400 mt-1 print:hidden">Pendapatan Bersih (Penjualan) dikurangi Harga Pokok Penjualan (HPP).</p>
            </div>
        </div>
    </div>

    <!-- Active Inventory Asset Valuation -->
    <div class="bg-slate-900 text-white rounded-2xl p-5 md:p-6 shadow-md border border-slate-800 print:bg-white print:text-slate-900 print:border-slate-300 print:shadow-none">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-white print:text-slate-900">Valuasi Aset Inventaris Terkini (Real-time)</h3>
                <p class="text-xs text-slate-400 print:text-slate-500 mt-0.5">Nilai aset barang yang saat ini masih tersedia di gudang/toko.</p>
            </div>
            <div class="grid grid-cols-3 gap-6 md:gap-10 text-left">
                <div>
                    <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400 print:text-slate-500">Total Stok</span>
                    <span class="text-lg font-bold text-white print:text-slate-900">{{ number_format($totalStok) }} <span class="text-xs font-normal">Unit</span></span>
                </div>
                <div>
                    <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400 print:text-slate-500">Nilai Aset (Beli)</span>
                    <span class="text-lg font-bold text-emerald-400 print:text-emerald-700">Rp {{ number_format($totalAsetBeli, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400 print:text-slate-500">Nilai Jual Aset</span>
                    <span class="text-lg font-bold text-blue-400 print:text-blue-700">Rp {{ number_format($totalAsetJual, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Header (Hidden on screen, shown on print) -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-2xl font-bold text-slate-950">Laporan Transaksi & Keuangan Inventaris</h1>
        <h2 class="text-xl font-semibold text-slate-800 mt-1">Zoiez Motor</h2>
        <p class="text-sm text-slate-600 mt-1">
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
        </p>
        <p class="text-xs text-slate-450 mt-0.5">Filter Tampilan Transaksi: {{ $type }}</p>
        <hr class="border-slate-300 mt-4">
    </div>

    <!-- Report Table Container -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden print:border-none print:shadow-none">
        <div class="overflow-x-auto">
            @if($transactions->count() > 0)
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider print:bg-slate-100">
                            <th scope="col" class="px-6 py-4 text-left rounded-l-lg">Tanggal</th>
                            <th scope="col" class="px-6 py-4 text-left">Kode & Barang</th>
                            <th scope="col" class="px-6 py-4 text-center">Jenis</th>
                            <th scope="col" class="px-6 py-4 text-center">Jumlah</th>
                            <th scope="col" class="px-6 py-4 text-right">Harga Satuan</th>
                            <th scope="col" class="px-6 py-4 text-right">Total Nilai</th>
                            <th scope="col" class="px-6 py-4 text-left rounded-r-lg">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($transactions as $tx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    {{ $tx->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900">{{ $tx->sparepart->nama_sparepart }}</div>
                                    <div class="text-xs text-slate-400">
                                        {{ $tx->sparepart->kode_sparepart }} &bull; {{ $tx->sparepart->kategori->nama_kategori }}
                                        @if($tx->jenis === 'Keluar' && $tx->atas_nama)
                                            &bull; <span class="text-blue-600 font-semibold">A.n. {{ $tx->atas_nama }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider print:border print:border-slate-300 {{ $tx->badge_color }}">
                                        {{ $tx->jenis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold {{ $tx->jenis === 'Masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->jenis === 'Masuk' ? '+' : '-' }}{{ $tx->jumlah }} {{ $tx->sparepart->satuan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-slate-600">
                                    @if($tx->jenis === 'Masuk')
                                        Rp {{ number_format($tx->harga_beli, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($tx->sparepart->harga_jual, 0, ',', '.') }}
                                        <div class="text-[10px] text-slate-400 print:hidden">HPP: Rp {{ number_format($tx->sparepart->harga_beli, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $tx->jenis === 'Masuk' ? 'text-slate-800' : 'text-blue-700' }}">
                                    @if($tx->jenis === 'Masuk')
                                        Rp {{ number_format($tx->harga_total, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($tx->jumlah * $tx->sparepart->harga_jual, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate italic">{{ $tx->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <span class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4 shadow-inner">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Tidak Ada Data</h3>
                    <p class="text-sm text-slate-500 max-w-xs mt-1">Tidak ditemukan transaksi pada rentang tanggal dan kriteria tersebut.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

