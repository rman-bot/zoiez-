<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('tanggal_mulai');
        $endDate = $request->input('tanggal_selesai');

        $query = BarangMasuk::with(['sparepart.kategori'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        $incomingLogs = $query->get();

        if ($request->input('export') === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('barang-masuk.pdf', compact('incomingLogs', 'startDate', 'endDate'));
            $pdf->setPaper('a4', 'portrait');
            return $pdf->download('laporan_barang_masuk_' . date('Ymd_His') . '.pdf');
        }

        return view('barang-masuk.index', compact('incomingLogs', 'startDate', 'endDate'));
    }

    public function create(Request $request)
    {
        $spareparts = Sparepart::orderBy('nama_sparepart', 'asc')->get();

        // Support pre-selecting a sparepart (e.g. from restok link)
        $selectedSparepartId = $request->input('sparepart_id');

        return view('barang-masuk.create', compact('spareparts', 'selectedSparepartId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sparepart_id'   => 'required|exists:spareparti,id',
            'jumlah'         => 'required|integer|min:1',
            'harga_beli'     => 'required|numeric|min:0',
            'tanggal'        => 'required|date',
            'keterangan'     => 'nullable|string',
        ], [
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.min'      => 'Harga beli tidak boleh negatif.',
        ]);

        DB::transaction(function () use ($request) {
            $jumlah     = (int) $request->jumlah;
            $hargaBeli  = (float) $request->harga_beli;
            $hargaTotal = $jumlah * $hargaBeli;

            // 1. Create transaction log with harga
            BarangMasuk::create([
                'sparepart_id' => $request->sparepart_id,
                'jumlah'       => $jumlah,
                'harga_beli'   => $hargaBeli,
                'harga_total'  => $hargaTotal,
                'tanggal'      => $request->tanggal,
                'keterangan'   => $request->keterangan,
            ]);

            // 2. Increment stock in spareparti
            $sparepart = Sparepart::findOrFail($request->sparepart_id);
            $sparepart->increment('stok', $jumlah);

            // 3. Optionally update the master harga_beli in spareparti
            if ($request->boolean('update_harga_master')) {
                $sparepart->update(['harga_beli' => $hargaBeli]);
            }
        });

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Stok masuk berhasil dicatat dan diupdate ke inventaris.');
    }
}
