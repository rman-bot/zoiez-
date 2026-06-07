<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();

        $query = Sparepart::with('kategori');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_sparepart', 'like', "%{$search}%")
                  ->orWhere('kode_sparepart', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        $spareparts = $query->orderBy('kode_sparepart', 'asc')->get();

        return view('sparepart.index', compact('spareparts', 'categories'));
    }

    public function create()
    {
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();

        // Check if there are no categories
        if ($categories->isEmpty()) {
            return redirect()->route('kategori.create')
                ->with('error', 'Silakan buat kategori terlebih dahulu sebelum menambah sparepart.');
        }

        // Auto-generate default code SP-XXX
        $latest = Sparepart::orderBy('id', 'desc')->first();
        $nextNumber = 1;
        if ($latest) {
            if (preg_match('/SP-(\d+)/', $latest->kode_sparepart, $matches)) {
                $nextNumber = (int)$matches[1] + 1;
            }
        }
        $defaultCode = 'SP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('sparepart.create', compact('categories', 'defaultCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sparepart' => 'required|string|max:50|unique:spareparti,kode_sparepart',
            'nama_sparepart' => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'merk' => 'nullable|string|max:100',
            'satuan' => 'required|string|max:30',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ], [
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
            'kode_sparepart.unique' => 'Kode sparepart ini sudah terdaftar.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->except('gambar');

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('spareparts', 'public');
        }

        Sparepart::create($data);

        return redirect()->route('sparepart.index')
            ->with('success', 'Sparepart baru berhasil ditambahkan.');
    }

    public function edit(Sparepart $sparepart)
    {
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('sparepart.edit', compact('sparepart', 'categories'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'kode_sparepart' => 'required|string|max:50|unique:spareparti,kode_sparepart,' . $sparepart->id,
            'nama_sparepart' => 'required|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'merk' => 'nullable|string|max:100',
            'satuan' => 'required|string|max:30',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_beli',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ], [
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
            'kode_sparepart.unique' => 'Kode sparepart ini sudah terdaftar.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->except('gambar');

        // Handle image upload - replace old image if new one is uploaded
        if ($request->hasFile('gambar')) {
            if ($sparepart->gambar) {
                Storage::disk('public')->delete($sparepart->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('spareparts', 'public');
        }

        // Handle image removal
        if ($request->boolean('hapus_gambar') && $sparepart->gambar) {
            Storage::disk('public')->delete($sparepart->gambar);
            $data['gambar'] = null;
        }

        $sparepart->update($data);

        return redirect()->route('sparepart.index')
            ->with('success', 'Data sparepart berhasil diubah.');
    }

    public function destroy(Sparepart $sparepart)
    {
        // Safety check: check if sparepart is in transaction history
        if ($sparepart->barangMasuk()->count() > 0 || $sparepart->barangKeluar()->count() > 0) {
            return redirect()->route('sparepart.index')
                ->with('error', 'Sparepart tidak dapat dihapus karena memiliki riwayat transaksi masuk/keluar.');
        }

        // Delete image from storage if exists
        if ($sparepart->gambar) {
            Storage::disk('public')->delete($sparepart->gambar);
        }

        $sparepart->delete();

        return redirect()->route('sparepart.index')
            ->with('success', 'Sparepart berhasil dihapus.');
    }
}
