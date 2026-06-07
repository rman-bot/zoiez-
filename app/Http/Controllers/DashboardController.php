<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Sparepart;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Core metrics
        $totalSpareparts = Sparepart::count();
        $totalCategories = Kategori::count();
        $barangMasukHariIni = BarangMasuk::whereDate('tanggal', today())->sum('jumlah');
        $barangKeluarHariIni = BarangKeluar::whereDate('tanggal', today())->sum('jumlah');

        // 2. Critical stock list (stok <= stok_minimal)
        $criticalSpareparts = Sparepart::with('kategori')
            ->whereColumn('stok', '<=', 'stok_minimal')
            ->orderBy('stok', 'asc')
            ->get();

        // 3. Merged recent transactions
        $recentMasuk = BarangMasuk::with('sparepart')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Masuk';
                $item->badge_color = 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20';
                return $item;
            });

        $recentKeluar = BarangKeluar::with('sparepart')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Keluar';
                $item->badge_color = 'bg-rose-500/10 text-rose-600 border border-rose-500/20';
                return $item;
            });

        $recentTransactions = $recentMasuk->concat($recentKeluar)
            ->sortByDesc('created_at')
            ->take(5);

        // 4. Past 7 days chart data
        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);
            $dateStr = $dateObj->format('Y-m-d');
            
            $chartLabels[] = $dateObj->locale('id')->isoFormat('D MMM');
            $chartMasuk[] = (int) BarangMasuk::whereDate('tanggal', $dateStr)->sum('jumlah');
            $chartKeluar[] = (int) BarangKeluar::whereDate('tanggal', $dateStr)->sum('jumlah');
        }

        return view('dashboard', compact(
            'totalSpareparts',
            'totalCategories',
            'barangMasukHariIni',
            'barangKeluarHariIni',
            'criticalSpareparts',
            'recentTransactions',
            'chartLabels',
            'chartMasuk',
            'chartKeluar'
        ));
    }
}
