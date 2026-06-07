@extends('layouts.app')

@section('title', 'Ubah Sparepart')
@section('page-title', 'Data Sparepart')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('sparepart.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
        <h3 class="text-xl font-bold text-slate-800 mt-2">Ubah Data Sparepart</h3>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8">
        <form action="{{ route('sparepart.update', $sparepart->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Warning note for manual stock edits -->
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-start gap-2.5">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <span class="font-bold">Pemberitahuan Audit:</span> Untuk penyesuaian stok harian yang akurat, sangat disarankan menggunakan menu <a href="{{ route('barang-masuk.index') }}" class="underline font-semibold hover:text-amber-950">Barang Masuk</a> atau <a href="{{ route('barang-keluar.index') }}" class="underline font-semibold hover:text-amber-950">Barang Keluar</a> agar tercatat riwayat transaksinya.
                </div>
            </div>

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Code Sparepart -->
                <div>
                    <label for="kode_sparepart" class="block text-sm font-semibold text-slate-700 mb-2">Kode Sparepart <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_sparepart" id="kode_sparepart" required value="{{ old('kode_sparepart', $sparepart->kode_sparepart) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Sparepart Name -->
                <div>
                    <label for="nama_sparepart" class="block text-sm font-semibold text-slate-700 mb-2">Nama Sparepart <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_sparepart" id="nama_sparepart" required value="{{ old('nama_sparepart', $sparepart->nama_sparepart) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Category -->
                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('kategori_id', $sparepart->kategori_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Merk / Brand -->
                <div>
                    <label for="merk" class="block text-sm font-semibold text-slate-700 mb-2">Merk / Merek</label>
                    <input type="text" name="merk" id="merk" value="{{ old('merk', $sparepart->merk) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Unit -->
                <div>
                    <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                    <input type="text" name="satuan" id="satuan" required value="{{ old('satuan', $sparepart->satuan) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Stock Manual Edit -->
                <div>
                    <label for="stok" class="block text-sm font-semibold text-slate-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" required min="0" value="{{ old('stok', $sparepart->stok) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Cost Price -->
                <div>
                    <label for="harga_beli" class="block text-sm font-semibold text-slate-700 mb-2">Harga Beli <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">Rp</span>
                        <input type="number" name="harga_beli" id="harga_beli" required min="0" value="{{ old('harga_beli', (int)$sparepart->harga_beli) }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 pl-9 pr-4 text-sm text-slate-800 focus:outline-none transition-all">
                    </div>
                </div>

                <!-- Selling Price -->
                <div>
                    <label for="harga_jual" class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">Rp</span>
                        <input type="number" name="harga_jual" id="harga_jual" required min="0" value="{{ old('harga_jual', (int)$sparepart->harga_jual) }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 pl-9 pr-4 text-sm text-slate-800 focus:outline-none transition-all">
                    </div>
                </div>

                <!-- Stock Minimal Alert -->
                <div>
                    <label for="stok_minimal" class="block text-sm font-semibold text-slate-700 mb-2">Batas Stok Minimal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok_minimal" id="stok_minimal" required min="0" value="{{ old('stok_minimal', $sparepart->stok_minimal) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Sparepart</label>
                    <div class="flex items-start gap-5">
                        <!-- Current / Preview image -->
                        <div id="image-preview-container" class="flex-shrink-0 w-28 h-28 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden">
                            @if($sparepart->gambar)
                                <img id="image-preview" src="{{ Storage::url($sparepart->gambar) }}" class="w-full h-full object-cover" alt="Foto Sparepart">
                                <svg id="image-placeholder-icon" class="w-8 h-8 text-slate-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @else
                                <svg id="image-placeholder-icon" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <img id="image-preview" src="" class="hidden w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <label for="gambar" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    {{ $sparepart->gambar ? 'Ganti Gambar' : 'Pilih Gambar' }}
                                </label>
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                                <p class="mt-1.5 text-xs text-slate-400">Format: JPG, PNG, GIF, WEBP. Maks. 2MB.</p>
                            </div>
                            @if($sparepart->gambar)
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1"
                                        class="h-4 w-4 bg-slate-50 border-slate-300 rounded text-red-500 focus:ring-red-500/20 focus:outline-none">
                                    <label for="hapus_gambar" class="text-xs font-semibold text-red-500 cursor-pointer">Hapus foto saat ini</label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description / Keterangan -->
                <div class="md:col-span-2">
                    <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">{{ old('keterangan', $sparepart->keterangan) }}</textarea>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('sparepart.index') }}" 
                    class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" 
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all duration-150">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder-icon');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
