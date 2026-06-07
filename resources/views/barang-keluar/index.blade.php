@extends('layouts.app')

@section('title', 'Barang Keluar')
@section('page-title', 'Riwayat Barang Keluar')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Mencatat penggunaan sparepart untuk servis motor atau penjualan suku cadang ke pelanggan.</p>
        </div>
        <div>
            <a href="{{ route('barang-keluar.create') }}" 
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Catat Barang Keluar
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($outgoingLogs->count() > 0)
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th scope="col" class="px-6 py-4 text-left rounded-l-lg">Tanggal Transaksi</th>
                            <th scope="col" class="px-6 py-4 text-left">Kode</th>
                            <th scope="col" class="px-6 py-4 text-left">Nama Sparepart</th>
                            <th scope="col" class="px-6 py-4 text-left">Kategori</th>
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
                        <!-- Box Outgoing Empty SVG -->
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2M7 7h10" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Riwayat</h3>
                    <p class="text-sm text-slate-500 max-w-xs mt-1">Anda belum mencatat transaksi barang keluar apapun.</p>
                    <a href="{{ route('barang-keluar.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                        Catat Barang Keluar Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
