@extends('layouts.app')

@section('title', 'Tambah Sparepart')
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
        <h3 class="text-xl font-bold text-slate-800 mt-2">Tambah Sparepart Baru</h3>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8">
        <form action="{{ route('sparepart.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Code Sparepart -->
                <div>
                    <label for="kode_sparepart" class="block text-sm font-semibold text-slate-700 mb-2">Kode Sparepart <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_sparepart" id="kode_sparepart" required value="{{ old('kode_sparepart', $defaultCode) }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="Contoh: SP-001">
                </div>

                <!-- Sparepart Name -->
                <div class="relative">
                    <label for="nama_sparepart" class="block text-sm font-semibold text-slate-700 mb-2">Nama Sparepart <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" name="nama_sparepart" id="nama_sparepart" required value="{{ old('nama_sparepart') }}" autocomplete="off"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                            placeholder="Contoh: Kampas Rem Depan Beat">
                        
                        <!-- Autocomplete suggestions dropdown -->
                        <div id="autocomplete-suggestions" class="hidden absolute left-0 right-0 z-50 mt-1 max-h-60 overflow-y-auto bg-white border border-slate-200 rounded-xl shadow-lg focus:outline-none"></div>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_id" id="kategori_id" required
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('kategori_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Merk / Brand -->
                <div>
                    <label for="merk" class="block text-sm font-semibold text-slate-700 mb-2">Merk / Merek</label>
                    <input type="text" name="merk" id="merk" value="{{ old('merk') }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="Contoh: Federal, AHM, GS Astra">
                </div>

                <!-- Unit -->
                <div>
                    <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                    <input type="text" name="satuan" id="satuan" required value="{{ old('satuan', 'pcs') }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="pcs, liter, set, dll (Contoh: pcs)">
                </div>

                <!-- Stock Initial -->
                <div>
                    <label for="stok" class="block text-sm font-semibold text-slate-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" required min="0" value="{{ old('stok', '0') }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="0">
                </div>

                <!-- Cost Price -->
                <div>
                    <label for="harga_beli" class="block text-sm font-semibold text-slate-700 mb-2">Harga Beli <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">Rp</span>
                        <input type="number" name="harga_beli" id="harga_beli" required min="0" value="{{ old('harga_beli') }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 pl-9 pr-4 text-sm text-slate-800 focus:outline-none transition-all"
                            placeholder="0">
                    </div>
                </div>

                <!-- Selling Price -->
                <div>
                    <label for="harga_jual" class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">Rp</span>
                        <input type="number" name="harga_jual" id="harga_jual" required min="0" value="{{ old('harga_jual') }}"
                            class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 pl-9 pr-4 text-sm text-slate-800 focus:outline-none transition-all"
                            placeholder="0">
                    </div>
                </div>

                <!-- Stock Minimal Alert -->
                <div>
                    <label for="stok_minimal" class="block text-sm font-semibold text-slate-700 mb-2">Batas Stok Minimal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok_minimal" id="stok_minimal" required min="0" value="{{ old('stok_minimal', '5') }}"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="5">
                    <p class="mt-1.5 text-xs text-slate-400">Notifikasi stok menipis akan terpicu jika stok di bawah atau sama dengan batas ini.</p>
                </div>

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <label for="gambar" class="block text-sm font-semibold text-slate-700 mb-2">Foto Sparepart</label>
                    <div class="flex items-start gap-4">
                        <!-- Preview placeholder -->
                        <div id="image-preview-container" class="flex-shrink-0 w-24 h-24 rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden">
                            <svg id="image-placeholder-icon" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <img id="image-preview" src="" class="hidden w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <label for="gambar" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Pilih Gambar
                            </label>
                            <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <p class="mt-2 text-xs text-slate-400">Format: JPG, PNG, GIF, WEBP. Maks. 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Description / Keterangan -->
                <div class="md:col-span-2">
                    <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-xl py-3 px-4 text-sm text-slate-800 focus:outline-none transition-all"
                        placeholder="Masukkan catatan tambahan jika ada...">{{ old('keterangan') }}</textarea>
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
                    Simpan Sparepart
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
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('nama_sparepart');
    const suggestionsContainer = document.getElementById('autocomplete-suggestions');
    const existingNames = @json($existingNames ?? []);
    let currentFocus = -1;

    // Show/filter suggestions
    function updateSuggestions() {
        const value = input.value.trim().toLowerCase();
        
        // Clear previous suggestions
        suggestionsContainer.innerHTML = '';
        currentFocus = -1;

        if (!value) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        // Filter names matching the typed text
        const matches = existingNames.filter(name => 
            name.toLowerCase().includes(value)
        );

        if (matches.length === 0) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        // Generate suggestions HTML
        matches.forEach((match, index) => {
            const item = document.createElement('div');
            item.setAttribute('id', `autocomplete-item-${index}`);
            item.className = 'px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-800 cursor-pointer transition-colors duration-150';
            
            // Highlight matching letters
            const regex = new RegExp(`(${escapeRegExp(value)})`, 'gi');
            const highlightedText = match.replace(regex, '<span class="font-bold text-blue-600">$1</span>');
            item.innerHTML = highlightedText;

            // Click handler
            item.addEventListener('click', function() {
                input.value = match;
                suggestionsContainer.classList.add('hidden');
            });

            suggestionsContainer.appendChild(item);
        });

        suggestionsContainer.classList.remove('hidden');
    }

    // Escape special regex characters
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Input event listener
    input.addEventListener('input', updateSuggestions);

    // Focus event listener
    input.addEventListener('focus', updateSuggestions);

    // Keyboard navigation
    input.addEventListener('keydown', function(e) {
        const items = suggestionsContainer.getElementsByTagName('div');
        if (items.length === 0) return;

        if (e.key === 'ArrowDown') {
            currentFocus++;
            addActive(items);
            e.preventDefault();
        } else if (e.key === 'ArrowUp') {
            currentFocus--;
            addActive(items);
            e.preventDefault();
        } else if (e.key === 'Enter') {
            if (currentFocus > -1) {
                e.preventDefault(); // Prevent form submission
                if (items[currentFocus]) {
                    items[currentFocus].click();
                }
            }
        } else if (e.key === 'Escape') {
            suggestionsContainer.classList.add('hidden');
        }
    });

    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;

        items[currentFocus].classList.add('bg-blue-50', 'text-blue-800', 'font-medium');
        // Scroll into view if out of container scroll viewport
        items[currentFocus].scrollIntoView({ block: 'nearest' });
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('bg-blue-50', 'text-blue-800', 'font-medium');
        }
    }

    // Close suggestions list when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target !== input && e.target !== suggestionsContainer && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.add('hidden');
        }
    });
});
</script>
@endsection
