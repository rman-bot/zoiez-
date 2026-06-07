<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default filter values
        $startDate = $request->input('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('tanggal_selesai', now()->format('Y-m-d'));
        $type = $request->input('jenis_transaksi', 'Semua');

        $transactions = collect();

        // 1. Fetch Incoming Logs if needed
        if ($type === 'Semua' || $type === 'Masuk') {
            $incoming = BarangMasuk::with(['sparepart.kategori'])
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    $item->jenis = 'Masuk';
                    $item->badge_color = 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20';
                    return $item;
                });
            $transactions = $transactions->concat($incoming);
        }

        // 2. Fetch Outgoing Logs if needed
        if ($type === 'Semua' || $type === 'Keluar') {
            $outgoing = BarangKeluar::with(['sparepart.kategori'])
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    $item->jenis = 'Keluar';
                    $item->badge_color = 'bg-rose-500/10 text-rose-600 border border-rose-500/20';
                    return $item;
                });
            $transactions = $transactions->concat($outgoing);
        }

        // 3. Sort the combined results
        $transactions = $transactions->sortByDesc(function ($item) {
            return $item->tanggal->format('Y-m-d') . ' ' . $item->created_at;
        });

        // 4. Calculate accounting metrics (always based on selected period)
        $allIncoming = BarangMasuk::with('sparepart')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
            
        $allOutgoing = BarangKeluar::with('sparepart')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $totalPembelian = $allIncoming->sum('harga_total');
        
        $totalPenjualan = $allOutgoing->sum(function ($item) {
            return $item->jumlah * ($item->sparepart->harga_jual ?? 0);
        });
        
        $totalHpp = $allOutgoing->sum(function ($item) {
            return $item->jumlah * ($item->sparepart->harga_beli ?? 0);
        });
        
        $labaKotor = $totalPenjualan - $totalHpp;

        // 5. Current Active Inventory Asset Valuation (Live stats)
        $spareparts = \App\Models\Sparepart::all();
        $totalAsetBeli = $spareparts->sum(function ($item) {
            return $item->stok * $item->harga_beli;
        });
        $totalAsetJual = $spareparts->sum(function ($item) {
            return $item->stok * $item->harga_jual;
        });
        $totalStok = $spareparts->sum('stok');

        if ($request->input('export') === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact(
                'transactions',
                'startDate',
                'endDate',
                'type',
                'totalPembelian',
                'totalPenjualan',
                'totalHpp',
                'labaKotor',
                'totalAsetBeli',
                'totalAsetJual',
                'totalStok'
            ));
            $pdf->setPaper('a4', 'portrait');
            return $pdf->download('laporan_keuangan_' . $startDate . '_to_' . $endDate . '.pdf');
        }

        return view('laporan.index', compact(
            'transactions', 
            'startDate', 
            'endDate', 
            'type',
            'totalPembelian',
            'totalPenjualan',
            'totalHpp',
            'labaKotor',
            'totalAsetBeli',
            'totalAsetJual',
            'totalStok'
        ));
    }
}
