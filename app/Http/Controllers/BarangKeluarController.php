<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $outgoingLogs = BarangKeluar::with(['sparepart.kategori'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('barang-keluar.index', compact('outgoingLogs'));
    }

    public function create(Request $request)
    {
        $spareparts = Sparepart::orderBy('nama_sparepart', 'asc')->get();

        // Support pre-selecting a sparepart
        $selectedSparepartId = $request->input('sparepart_id');

        return view('barang-keluar.create', compact('spareparts', 'selectedSparepartId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparti,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $sparepart = Sparepart::findOrFail($request->sparepart_id);

        // Validation rule: Outgoing quantity cannot exceed current stock
        if ($request->jumlah > $sparepart->stok) {
            return back()->withErrors([
                'jumlah' => "Stok tidak mencukupi. Stok saat ini untuk {$sparepart->nama_sparepart} adalah {$sparepart->stok} {$sparepart->satuan}.",
            ])->withInput();
        }

        DB::transaction(function () use ($request, $sparepart) {
            // 1. Create transaction log
            BarangKeluar::create([
                'sparepart_id' => $request->sparepart_id,
                'jumlah' => $request->jumlah,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            // 2. Decrement stock in spareparti
            $sparepart->decrement('stok', $request->jumlah);
        });

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Stok keluar berhasil dicatat dan diupdate ke inventaris.');
    }
}
