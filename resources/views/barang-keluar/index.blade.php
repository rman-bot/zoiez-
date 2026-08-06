@extends('layouts.app')

@section('title', 'Barang Keluar')
@section('page-title', 'Riwayat Barang Keluar')

@section('content')
<style>
@media print {
    @page {
        margin: 1.5cm 1.2cm 1.5cm 1.2cm;
        size: A4 portrait;
    }
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
    tr {
        page-break-inside: avoid !important;
    }
}
</style>

<div class="space-y-6 animate-fade-in">

    <!-- Action Bar & Filter Form -->
    <div class="flex flex-col gap-4 print:hidden">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Mencatat penggunaan sparepart untuk servis motor atau penjualan suku cadang ke pelanggan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <!-- Unduh PDF -->
                <a href="{{ route('barang-keluar.index', array_merge(request()->query(), ['export' => 'pdf'])) }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-sm transition-all">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M5 20h14a2 2 0 002-2V8l-6-6H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Unduh PDF
                </a>
                
                <!-- Cetak Halaman -->
                <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 active:bg-slate-100 border border-slate-200 rounded-xl shadow-sm transition-all">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Halaman
                </button>

                <!-- Catat Barang Keluar -->
                <a href="{{ route('barang-keluar.create') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 active:bg-slate-950 rounded-xl shadow-sm transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Catat Barang Keluar
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white border border-slate-150 rounded-2xl shadow-sm p-4 md:p-5">
            <form action="{{ route('barang-keluar.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="tanggal_mulai" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ $startDate }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ $endDate }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="flex-1 justify-center inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 active:bg-slate-900 rounded-xl transition-all">
                        Filter Tanggal
                    </button>
                    <a href="{{ route('barang-keluar.index') }}" 
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

    <!-- Printable Header (Only visible on browser print) -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-2xl font-bold text-slate-950">Laporan Barang Keluar</h1>
        <h2 class="text-xl font-semibold text-slate-800 mt-1">Zoiez Motor</h2>
        <p class="text-sm text-slate-600 mt-1">
            @if($startDate && $endDate)
                Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
            @else
                Periode: <strong>Semua Transaksi</strong>
            @endif
            &nbsp;|&nbsp; Cetak: {{ now()->format('d/m/Y H:i') }}
        </p>
        <hr class="border-slate-300 mt-4">
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden print:border-none print:shadow-none">
        <div class="overflow-x-auto">
            @if($outgoingLogs->count() > 0)
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider print:bg-slate-100">
                            <th scope="col" class="px-6 py-4 text-left rounded-l-lg">Tanggal Transaksi</th>
                            <th scope="col" class="px-6 py-4 text-left">Kode</th>
                            <th scope="col" class="px-6 py-4 text-left">Nama Sparepart</th>
                            <th scope="col" class="px-6 py-4 text-left">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-left">Atas Nama</th>
                            <th scope="col" class="px-6 py-4 text-center">Jumlah Keluar</th>
                            <th scope="col" class="px-6 py-4 text-left rounded-r-lg">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($outgoingLogs as $log)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    {{ $log->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-700">{{ $log->sparepart->kode_sparepart }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">{{ $log->sparepart->nama_sparepart }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $log->sparepart->kategori->nama_kategori }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-700">{{ $log->atas_nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-rose-600 bg-rose-50/50 rounded-lg">
                                    -{{ $log->jumlah }} {{ $log->sparepart->satuan }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate italic">{{ $log->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <span class="flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-400 mb-4 shadow-inner">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2M7 7h10" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Riwayat</h3>
                    <p class="text-sm text-slate-500 max-w-xs mt-1">Tidak ditemukan transaksi barang keluar pada kriteria tersebut.</p>
                    <a href="{{ route('barang-keluar.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                        Catat Barang Keluar Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
