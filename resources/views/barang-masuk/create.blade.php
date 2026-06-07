@extends('layouts.app')

@section('title', 'Catat Barang Masuk')
@section('page-title', 'Barang Masuk')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('barang-masuk.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Riwayat
        </a>
        <h3 class="text-xl font-bold text-slate-800 mt-2">Catat Transaksi Barang Masuk</h3>
    </div>

    <!-- Sparepart data for JS (price + image) -->
    <div id="sparepart-data" class="hidden"
        data-spareparts="{{ json_encode($spareparts->map(fn($p) => [
            'id'        => $p->id,
            'harga_beli'=> (float)$p->harga_beli,
            'gambar'    => $p->gambar ? Storage::url($p->gambar) : null,
            'nama'      => $p->nama_sparepart,
            'kode'      => $p->kode_sparepart,
            'stok'      => $p->stok,
            'satuan'    => $p->satuan,
        ])->keyBy('id')) }}">
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8">
        <form action="{{ route('barang-masuk.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Sparepart Selection -->
            <div>
                <label for="sparepart_id" class="block text-sm font-semibold text-slate-700 mb-2">
                    Pilih Sparepart <span class="text-red-500">*</span>
                </label>

                <!-- Dropdown + Image Preview side by side -->
                <div class="flex items-start gap-3">
                    <div class="flex-1 min-w-0">
                        <select name="sparepart_id" id="sparepart_id" required onchange="onSparepartChange()"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                            <option value="">-- Pilih Sparepart --</option>
                            @foreach($spareparts as $part)
                                <option value="{{ $part->id }}"
                                    {{ (old('sparepart_id') == $part->id || $selectedSparepartId == $part->id) ? 'selected' : '' }}>
                                    {{ $part->kode_sparepart }} - {{ $part->nama_sparepart }} (Stok: {{ $part->stok }} {{ $part->satuan }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs text-slate-400">Pilih item sparepart yang akan dimasukkan atau ditambah stoknya.</p>
                    </div>

                    <!-- Image Preview Box -->
                    <div id="sp-img-box"
                        class="flex-shrink-0 w-20 h-20 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center transition-all duration-300">
                        <div id="sp-img-placeholder" class="flex flex-col items-center gap-1 px-1">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[9px] text-slate-300 font-medium text-center leading-tight">Foto<br>Sparepart</span>
                        </div>
                        <img id="sp-img-preview" src="" alt="Foto Sparepart"
                            class="hidden w-full h-full object-cover">
                    </div>
                </div>

                <!-- Info chip (appears after selection) -->
                <div id="sparepart-info-chip" class="hidden mt-3 flex items-center gap-3 px-4 py-2.5 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="min-w-0">
                        <p id="chip-name" class="text-xs font-bold text-emerald-800 truncate"></p>
                        <p id="chip-stok" class="text-xs text-emerald-600"></p>
                    </div>
                </div>
            </div>

            <!-- Grid for Quantity & Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Quantity -->
                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Masuk <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="jumlah" required min="1" value="{{ old('jumlah', '1') }}"
                        oninput="calcTotal()"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="Contoh: 10">
                </div>

                <!-- Date -->
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                </div>
            </div>

            <!-- Harga Section -->
            <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-5 space-y-4">
                <p class="text-sm font-bold text-blue-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Harga Pembelian
                </p>

                <!-- Harga Source Toggle -->
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="harga_mode" id="harga_mode_auto" value="auto" checked onchange="onHargaModeChange()"
                            class="h-4 w-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                        <span class="text-sm font-semibold text-slate-700">Pakai harga data sparepart</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="harga_mode" id="harga_mode_manual" value="manual" onchange="onHargaModeChange()"
                            class="h-4 w-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                        <span class="text-sm font-semibold text-slate-700">Input harga manual</span>
                    </label>
                </div>

                <!-- Harga Beli Input -->
                <div>
                    <label for="harga_beli" class="block text-sm font-semibold text-slate-700 mb-2">Harga Beli per Satuan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm font-semibold">Rp</span>
                        <input type="number" name="harga_beli" id="harga_beli" required min="0" value="{{ old('harga_beli', '0') }}"
                            oninput="calcTotal()"
                            class="w-full bg-white border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 pl-10 pr-4 text-sm text-slate-800 focus:outline-none transition-all"
                            placeholder="0" readonly>
                    </div>
                    <p id="harga_hint" class="mt-1.5 text-xs text-slate-400">Terisi otomatis sesuai data master sparepart. Pilih "Input harga manual" untuk mengubah.</p>
                </div>

                <!-- Update Master Harga Checkbox -->
                <div id="update_master_wrapper" class="hidden">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" name="update_harga_master" id="update_harga_master" value="1"
                            class="mt-0.5 h-4 w-4 bg-slate-50 border-slate-300 rounded text-blue-600 focus:ring-blue-500/20">
                        <span class="text-xs text-slate-600 leading-relaxed">
                            <span class="font-semibold text-slate-700">Perbarui harga beli master sparepart</span><br>
                            Centang ini jika ingin menyimpan harga beli baru ini ke data utama sparepart.
                        </span>
                    </label>
                </div>

                <!-- Total -->
                <div class="flex items-center justify-between pt-3 border-t border-blue-200/60">
                    <span class="text-sm font-semibold text-slate-700">Harga Total</span>
                    <span id="harga_total_display" class="text-xl font-bold text-blue-700 tabular-nums">Rp 0</span>
                </div>
            </div>

            <!-- Description / Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Catatan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                    class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                    placeholder="Contoh: Restok dari Supplier A, barang retur, dll...">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('barang-masuk.index') }}" 
                    class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" 
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all duration-150">
                    Simpan &amp; Update Stok
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    const sparepartDataEl = document.getElementById('sparepart-data');
    const sparepartMap    = JSON.parse(sparepartDataEl.getAttribute('data-spareparts') || '{}');

    function formatRupiah(num) {
        return 'Rp ' + Math.round(num).toLocaleString('id-ID');
    }

    function getSelected() {
        const id = document.getElementById('sparepart_id').value;
        return id && sparepartMap[id] ? sparepartMap[id] : null;
    }

    /* ---- Image Preview ---- */
    function updateImagePreview(data) {
        const imgEl          = document.getElementById('sp-img-preview');
        const placeholder    = document.getElementById('sp-img-placeholder');
        const box            = document.getElementById('sp-img-box');

        if (data && data.gambar) {
            imgEl.src = data.gambar;
            imgEl.classList.remove('hidden');
            placeholder.classList.add('hidden');
            box.classList.remove('border-dashed', 'border-slate-200', 'bg-slate-50');
            box.classList.add('border-solid', 'border-blue-200', 'shadow-md');
        } else {
            imgEl.src = '';
            imgEl.classList.add('hidden');
            placeholder.classList.remove('hidden');
            box.classList.add('border-dashed', 'border-slate-200', 'bg-slate-50');
            box.classList.remove('border-solid', 'border-blue-200', 'shadow-md');
        }
    }

    /* ---- Info Chip ---- */
    function updateInfoChip(data) {
        const chip = document.getElementById('sparepart-info-chip');
        if (data) {
            document.getElementById('chip-name').textContent = data.kode + ' — ' + data.nama;
            document.getElementById('chip-stok').textContent = 'Stok saat ini: ' + data.stok + ' ' + data.satuan;
            chip.classList.remove('hidden');
        } else {
            chip.classList.add('hidden');
        }
    }

    /* ---- Main sparepart change handler ---- */
    function onSparepartChange() {
        const data = getSelected();

        // Update image & chip
        updateImagePreview(data);
        updateInfoChip(data);

        // Update harga if mode=auto
        const mode = document.querySelector('input[name="harga_mode"]:checked').value;
        if (mode === 'auto') {
            document.getElementById('harga_beli').value = data ? data.harga_beli : 0;
        }
        calcTotal();
    }

    function onHargaModeChange() {
        const mode         = document.querySelector('input[name="harga_mode"]:checked').value;
        const hargaInput   = document.getElementById('harga_beli');
        const hint         = document.getElementById('harga_hint');
        const masterWrapper= document.getElementById('update_master_wrapper');
        const data         = getSelected();

        if (mode === 'auto') {
            hargaInput.value = data ? data.harga_beli : 0;
            hargaInput.setAttribute('readonly', true);
            hargaInput.classList.replace('bg-yellow-50', 'bg-white');
            hint.textContent = 'Terisi otomatis sesuai data master sparepart. Pilih "Input harga manual" untuk mengubah.';
            hint.classList.replace('text-amber-600', 'text-slate-400');
            masterWrapper.classList.add('hidden');
        } else {
            hargaInput.removeAttribute('readonly');
            hargaInput.classList.replace('bg-white', 'bg-yellow-50');
            hargaInput.focus();
            hint.textContent = 'Masukkan harga beli sesuai faktur / nota pembelian saat ini.';
            hint.classList.replace('text-slate-400', 'text-amber-600');
            masterWrapper.classList.remove('hidden');
        }
        calcTotal();
    }

    function calcTotal() {
        const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
        const harga  = parseFloat(document.getElementById('harga_beli').value) || 0;
        document.getElementById('harga_total_display').textContent = formatRupiah(jumlah * harga);
    }

    // Init on page load
    document.addEventListener('DOMContentLoaded', function () {
        onSparepartChange();
        @if(old('harga_beli') && old('harga_beli') > 0)
            document.getElementById('harga_mode_manual').checked = true;
            onHargaModeChange();
            document.getElementById('harga_beli').value = "{{ old('harga_beli') }}";
            calcTotal();
        @endif
    });
</script>
@endsection
