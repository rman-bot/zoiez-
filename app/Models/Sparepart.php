<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sparepart extends Model
{
    protected $table = 'spareparti';

    protected $fillable = [
        'kategori_id',
        'kode_sparepart',
        'gambar',
        'nama_sparepart',
        'merk',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimal',
        'keterangan',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'stok_minimal' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function barangMasuk(): HasMany
    {
        return $this->hasMany(BarangMasuk::class, 'sparepart_id');
    }

    public function barangKeluar(): HasMany
    {
        return $this->hasMany(BarangKeluar::class, 'sparepart_id');
    }

    public function isStokMenipis(): bool
    {
        return $this->stok <= $this->stok_minimal;
    }
}
