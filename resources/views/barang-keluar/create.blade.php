@extends('layouts.app')

@section('title', 'Catat Barang Keluar')
@section('page-title', 'Barang Keluar')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('barang-keluar.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Riwayat
        </a>
        <h3 class="text-xl font-bold text-slate-800 mt-2">Catat Transaksi Barang Keluar</h3>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8">
        <form action="{{ route('barang-keluar.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Sparepart Selection -->
            <div>
                <label for="sparepart_id" class="block text-sm font-semibold text-slate-700 mb-2">Pilih Sparepart <span class="text-red-500">*</span></label>
                <select name="sparepart_id" id="sparepart_id" required
                    class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                    <option value="">-- Pilih Sparepart --</option>
                    @foreach($spareparts as $part)
                        <!-- If stock is 0, we can disable it or let users select it and fail at validation, disabling it is cleaner, but let's allow it so validation message shows up, but mark it clearly -->
                        <option value="{{ $part->id }}" 
                            {{ (old('sparepart_id') == $part->id || $selectedSparepartId == $part->id) ? 'selected' : '' }}
                            {{ $part->stok == 0 ? 'disabled class=text-slate-350' : '' }}>
                            {{ $part->kode_sparepart }} - {{ $part->nama_sparepart }} (Stok Saat Ini: {{ $part->stok }} {{ $part->satuan }}) {{ $part->stok == 0 ? '[STOK HABIS]' : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1.5 text-xs text-slate-400">Pilih item sparepart yang akan dikurangi stoknya.</p>
            </div>

            <!-- Grid for Quantity & Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Quantity -->
                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Keluar <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="jumlah" required min="1" value="{{ old('jumlah', '1') }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="Contoh: 2">
                    @error('jumlah')
                        <p class="mt-2 text-xs text-red-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>
            </div>

            <!-- Description / Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Catatan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                    placeholder="Contoh: Digunakan untuk servis Beat putih B 1234 XY, penjualan langsung, dll...">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('barang-keluar.index') }}" 
                    class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" 
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all duration-150">
                    Simpan & Update Stok
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
