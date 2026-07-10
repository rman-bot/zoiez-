@extends('layouts.app')

@section('title', 'Catat Barang Keluar')
@section('page-title', 'Barang Keluar')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    
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

            <!-- Header Grid for Atas Nama & Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Atas Nama -->
                <div>
                    <label for="atas_nama" class="block text-sm font-semibold text-slate-700 mb-2">Atas Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="atas_nama" id="atas_nama" required value="{{ old('atas_nama') }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="Nama pelanggan / Keperluan (e.g. Budi Santoso)">
                </div>

                <!-- Date -->
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>
            </div>

            <!-- Spareparts List Section -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-md font-bold text-slate-800">Daftar Item Sparepart</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Pilih sparepart dan tentukan jumlah yang dikeluarkan.</p>
                    </div>
                    <button type="button" id="btn-add-item"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Item
                    </button>
                </div>

                <div id="items-container" class="space-y-4">
                    @php
                        $oldItems = old('items', []);
                        if (empty($oldItems) && isset($selectedSparepartId) && $selectedSparepartId) {
                            $oldItems[] = ['sparepart_id' => $selectedSparepartId, 'jumlah' => 1];
                        }
                        if (empty($oldItems)) {
                            $oldItems[] = ['sparepart_id' => '', 'jumlah' => 1];
                        }
                    @endphp

                    @foreach($oldItems as $index => $oldItem)
                        <div class="item-row grid grid-cols-12 gap-3 items-end bg-slate-50/50 border border-slate-100 p-4 rounded-2xl relative" data-index="{{ $index }}">
                            <!-- Sparepart Dropdown -->
                            <div class="col-span-12 sm:col-span-7">
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Sparepart <span class="text-red-500">*</span></label>
                                <select name="items[{{ $index }}][sparepart_id]" required onchange="updateStockLabel(this)"
                                    class="sparepart-select w-full bg-white border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                                    <option value="">-- Pilih Sparepart --</option>
                                    @foreach($spareparts as $part)
                                        <option value="{{ $part->id }}" 
                                            data-stok="{{ $part->stok }}"
                                            data-satuan="{{ $part->satuan }}"
                                            {{ $oldItem['sparepart_id'] == $part->id ? 'selected' : '' }}
                                            {{ ($part->stok == 0 && $oldItem['sparepart_id'] != $part->id) ? 'disabled class=text-slate-350' : '' }}>
                                            {{ $part->kode_sparepart }} - {{ $part->nama_sparepart }} (Stok: {{ $part->stok }} {{ $part->satuan }}) {{ $part->stok == 0 ? '[HABIS]' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity Input -->
                            <div class="col-span-9 sm:col-span-4">
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Jumlah Keluar <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="items[{{ $index }}][jumlah]" required min="1" value="{{ $oldItem['jumlah'] }}"
                                        class="quantity-input w-full bg-white border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 pr-12 text-sm text-slate-800 focus:outline-none transition-all"
                                        placeholder="1">
                                    <span class="unit-label absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                                        pcs
                                    </span>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <div class="col-span-3 sm:col-span-1 text-right">
                                <button type="button" onclick="removeItemRow(this)"
                                    class="btn-remove-item p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all inline-flex items-center justify-center w-full"
                                    title="Hapus Sparepart">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Description / Keterangan -->
            <div class="pt-4 border-t border-slate-100">
                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Catatan Tambahan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                    placeholder="Contoh: Servis rutin motor bebek, ganti komponen aus, penjualan langsung, dll...">{{ old('keterangan') }}</textarea>
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

<script>
let rowIndex = {{ count($oldItems) }};

document.getElementById('btn-add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const newRow = document.createElement('div');
    newRow.className = 'item-row grid grid-cols-12 gap-3 items-end bg-slate-50/50 border border-slate-100 p-4 rounded-2xl relative';
    newRow.setAttribute('data-index', rowIndex);

    let optionsHtml = '<option value="">-- Pilih Sparepart --</option>';
    @foreach($spareparts as $part)
        optionsHtml += `<option value="{{ $part->id }}" data-stok="{{ $part->stok }}" data-satuan="{{ $part->satuan }}" {{ $part->stok == 0 ? 'disabled class=text-slate-350' : '' }}>{{ $part->kode_sparepart }} - {{ $part->nama_sparepart }} (Stok: {{ $part->stok }} {{ $part->satuan }}) {{ $part->stok == 0 ? '[HABIS]' : '' }}</option>`;
    @endforeach

    newRow.innerHTML = `
        <!-- Sparepart Dropdown -->
        <div class="col-span-12 sm:col-span-7">
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Sparepart <span class="text-red-500">*</span></label>
            <select name="items[${rowIndex}][sparepart_id]" required onchange="updateStockLabel(this)"
                class="sparepart-select w-full bg-white border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 text-sm text-slate-800 focus:outline-none transition-all">
                ${optionsHtml}
            </select>
        </div>

        <!-- Quantity Input -->
        <div class="col-span-9 sm:col-span-4">
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Jumlah Keluar <span class="text-red-500">*</span></label>
            <div class="relative">
                <input type="number" name="items[${rowIndex}][jumlah]" required min="1" value="1"
                    class="quantity-input w-full bg-white border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-2.5 px-3.5 pr-12 text-sm text-slate-800 focus:outline-none transition-all"
                    placeholder="1">
                <span class="unit-label absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                    pcs
                </span>
            </div>
        </div>

        <!-- Remove Button -->
        <div class="col-span-3 sm:col-span-1 text-right">
            <button type="button" onclick="removeItemRow(this)"
                class="btn-remove-item p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all inline-flex items-center justify-center w-full"
                title="Hapus Sparepart">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    `;

    container.appendChild(newRow);
    rowIndex++;
    updateRemoveButtonsVisibility();
});

function removeItemRow(button) {
    const row = button.closest('.item-row');
    row.remove();
    updateRemoveButtonsVisibility();
}

function updateStockLabel(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const unitLabel = selectElement.closest('.item-row').querySelector('.unit-label');
    const quantityInput = selectElement.closest('.item-row').querySelector('.quantity-input');
    
    if (selectedOption && selectedOption.value) {
        const satuan = selectedOption.getAttribute('data-satuan');
        const maxStok = selectedOption.getAttribute('data-stok');
        
        unitLabel.textContent = satuan;
        quantityInput.setAttribute('max', maxStok);
    } else {
        unitLabel.textContent = 'pcs';
        quantityInput.removeAttribute('max');
    }
}

function updateRemoveButtonsVisibility() {
    const rows = document.querySelectorAll('.item-row');
    rows.forEach(row => {
        const removeBtn = row.querySelector('.btn-remove-item');
        if (rows.length === 1) {
            removeBtn.disabled = true;
            removeBtn.classList.add('opacity-40', 'cursor-not-allowed');
            removeBtn.classList.remove('hover:text-red-500', 'hover:bg-red-50');
        } else {
            removeBtn.disabled = false;
            removeBtn.classList.remove('opacity-40', 'cursor-not-allowed');
            removeBtn.classList.add('hover:text-red-500', 'hover:bg-red-50');
        }
    });
}

// Initial call
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sparepart-select').forEach(updateStockLabel);
    updateRemoveButtonsVisibility();
});
</script>
@endsection
