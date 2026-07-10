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
            'atas_nama' => 'required|string|max:150',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.sparepart_id' => 'required|exists:spareparti,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'atas_nama.required' => 'Kolom Atas Nama wajib diisi.',
            'items.required' => 'Minimal harus ada satu sparepart yang dipilih.',
            'items.*.sparepart_id.required' => 'Pilih sparepart terlebih dahulu.',
            'items.*.jumlah.required' => 'Jumlah keluar harus diisi.',
            'items.*.jumlah.min' => 'Jumlah keluar minimal 1.',
        ]);

        $items = $request->input('items', []);

        // Validate stock availability for each sparepart (aggregating duplicates if any)
        $groupedQuantities = [];
        foreach ($items as $item) {
            $spId = $item['sparepart_id'];
            $qty = (int)$item['jumlah'];
            if (!isset($groupedQuantities[$spId])) {
                $groupedQuantities[$spId] = 0;
            }
            $groupedQuantities[$spId] += $qty;
        }

        foreach ($groupedQuantities as $spId => $totalQty) {
            $sparepart = Sparepart::findOrFail($spId);
            if ($totalQty > $sparepart->stok) {
                return back()->withErrors([
                    'items' => "Stok tidak mencukupi. Total pengeluaran untuk {$sparepart->nama_sparepart} adalah {$totalQty} {$sparepart->satuan}, sedangkan stok saat ini hanya {$sparepart->stok} {$sparepart->satuan}."
                ])->withInput();
            }
        }

        // Save multiple spareparts in a transaction
        DB::transaction(function () use ($request, $items) {
            foreach ($items as $item) {
                $sparepart = Sparepart::findOrFail($item['sparepart_id']);

                // 1. Create transaction log
                BarangKeluar::create([
                    'sparepart_id' => $item['sparepart_id'],
                    'jumlah' => $item['jumlah'],
                    'atas_nama' => $request->atas_nama,
                    'tanggal' => $request->tanggal,
                    'keterangan' => $request->keterangan,
                ]);

                // 2. Decrement stock
                $sparepart->decrement('stok', $item['jumlah']);
            }
        });

        return redirect()->route('barang-keluar.index')
            ->with('success', 'Stok keluar berhasil dicatat dan diupdate ke inventaris.');
    }
}
