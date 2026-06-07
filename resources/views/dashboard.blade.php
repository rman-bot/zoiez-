@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Ringkasan')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        
        <!-- Total Spareparts Card -->
        <div class="bg-white overflow-hidden shadow-sm hover:shadow-md border border-slate-100 rounded-2xl p-6 flex items-center gap-5 transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-blue-600">
                <!-- Sparepart / Tool SVG -->
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Item Sparepart</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalSpareparts }}</h3>
            </div>
        </div>

        <!-- Total Kategori Card -->
        <div class="bg-white overflow-hidden shadow-sm hover:shadow-md border border-slate-100 rounded-2xl p-6 flex items-center gap-5 transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600">
                <!-- Folder / Category SVG -->
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Kategori Sparepart</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalCategories }}</h3>
            </div>
        </div>

        <!-- Barang Masuk Hari Ini -->
        <div class="bg-white overflow-hidden shadow-sm hover:shadow-md border border-slate-100 rounded-2xl p-6 flex items-center gap-5 transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600">
                <!-- Inbox In SVG -->
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Stok Masuk Hari Ini</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $barangMasukHariIni }}</h3>
            </div>
        </div>

        <!-- Barang Keluar Hari Ini -->
        <div class="bg-white overflow-hidden shadow-sm hover:shadow-md border border-slate-100 rounded-2xl p-6 flex items-center gap-5 transition-all">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 text-amber-600">
                <!-- Inbox Out SVG -->
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Stok Keluar Hari Ini</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $barangKeluarHariIni }}</h3>
            </div>
        </div>

    </div>

    <!-- Alarm / Critical Stock Warning -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $criticalSpareparts->count() > 0 ? 'bg-red-400' : 'bg-emerald-400' }} opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 {{ $criticalSpareparts->count() > 0 ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                </span>
                <h3 class="text-base font-bold text-slate-800">Status & Peringatan Stok Menipis</h3>
            </div>
            @if($criticalSpareparts->count() > 0)
                <span class="px-2.5 py-1 text-xs font-bold bg-red-100 text-red-800 rounded-full">
                    {{ $criticalSpareparts->count() }} Item Kritis
                </span>
            @endif
        </div>
        <div class="p-6">
            @if($criticalSpareparts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50">
                                <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider rounded-l-lg">Kode</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Sparepart</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Saat Ini</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Minimal</th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($criticalSpareparts as $part)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3.5 whitespace-nowrap text-sm font-semibold text-slate-700">{{ $part->kode_sparepart }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $part->nama_sparepart }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-sm text-slate-500">{{ $part->kategori->nama_kategori }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-center text-sm font-bold text-red-600 bg-red-50/50 rounded-lg">{{ $part->stok }} {{ $part->satuan }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-center text-sm text-slate-500 font-medium">{{ $part->stok_minimal }} {{ $part->satuan }}</td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-center text-sm">
                                        <a href="{{ route('barang-masuk.create', ['sparepart_id' => $part->id]) }}" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-xl text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Restok
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    <span class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 mb-3 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <h4 class="text-sm font-bold text-slate-800">Semua Stok Aman</h4>
                    <p class="text-xs text-slate-500 mt-1">Belum ada sparepart dengan stok di bawah batas minimal.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Visual Charts & Recent Transactions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Transaction Chart -->
        <div class="bg-white border border-slate-150 rounded-2xl shadow-sm lg:col-span-2 p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800 mb-6">Tren Transaksi Masuk vs Keluar (7 Hari Terakhir)</h3>
                <div class="h-64 w-full relative">
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Recent Transactions Feed -->
        <div class="bg-white border border-slate-150 rounded-2xl shadow-sm p-6 flex flex-col">
            <h3 class="text-base font-bold text-slate-800 mb-4">Aktivitas Transaksi Terbaru</h3>
            <div class="flex-1 flow-root">
                @if($recentTransactions->count() > 0)
                    <ul class="-mb-8">
                        @foreach($recentTransactions as $index => $tx)
                            <li>
                                <div class="relative pb-8">
                                    @if ($index < $recentTransactions->count() - 1)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-100" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white {{ $tx->jenis === 'Masuk' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                                @if ($tx->jenis === 'Masuk')
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-6l-7 7-7-7" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">
                                                    {{ $tx->sparepart->nama_sparepart }}
                                                </p>
                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    Jumlah: <strong class="text-slate-700 font-bold">{{ $tx->jumlah }} {{ $tx->sparepart->satuan }}</strong>
                                                    @if($tx->keterangan) 
                                                        <span class="italic text-slate-400">({{ $tx->keterangan }})</span> 
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right whitespace-nowrap text-xs text-slate-500">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold uppercase tracking-wider {{ $tx->badge_color }}">
                                                    {{ $tx->jenis }}
                                                </span>
                                                <time class="block text-2xs text-slate-400 mt-1">{{ $tx->tanggal->format('d/m/Y') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-center py-8">
                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-50 text-slate-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <p class="text-xs font-bold text-slate-500">Belum Ada Transaksi</p>
                        <p class="text-2xs text-slate-400 mt-0.5">Transaksi masuk & keluar akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

<!-- Include ChartJS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('transactionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: {!! json_encode($chartMasuk) !!},
                        backgroundColor: '#10b981', // emerald-500
                        borderRadius: 6,
                        borderSkipped: false
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode($chartKeluar) !!},
                        backgroundColor: '#f43f5e', // rose-500
                        borderRadius: 6,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Inter',
                                size: 12,
                                weight: '500'
                            },
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            family: 'Inter',
                            size: 13,
                            weight: '700'
                        },
                        bodyFont: {
                            family: 'Inter',
                            size: 12
                        },
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            color: '#64748b'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9'
                        },
                        border: {
                            dash: [4, 4]
                        },
                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },
                            color: '#64748b',
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
