@extends('layouts.app')

@section('title', 'Kategori Sparepart')
@section('page-title', 'Daftar Kategori')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Kelola kategori pengelompokan item sparepart di bengkel.</p>
        </div>
        <div>
            <a href="{{ route('kategori.create') }}" 
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white border border-slate-150 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($categories->count() > 0)
                <table class="min-w-full divide-y divide-slate-200">
                    <thead>
                        <tr class="bg-slate-50">
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider rounded-l-lg">Nama Kategori</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Sparepart</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($categories as $cat)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-800">{{ $cat->nama_kategori }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">{{ $cat->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cat->spareparts_count > 0 ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $cat->spareparts_count }} Item
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kategori.edit', $cat->id) }}" 
                                            class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                            title="Ubah">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        
                                        <!-- Hapus Button/Form -->
                                        <form action="{{ route('kategori.destroy', $cat->id) }}" method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="inline-flex items-center justify-center p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all"
                                                title="Hapus"
                                                {{ $cat->spareparts_count > 0 ? 'disabled style=opacity:0.3;cursor:not-allowed;' : '' }}>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-slate-50 text-slate-400 mb-4">
                        <!-- Empty Folder SVG -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </span>
                    <h3 class="text-base font-bold text-slate-800">Kategori Kosong</h3>
                    <p class="text-sm text-slate-500 max-w-xs mt-1">Anda belum membuat kategori sparepart apapun.</p>
                    <a href="{{ route('kategori.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                        Buat Kategori Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
