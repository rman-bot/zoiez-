<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $fillable = [
        'sparepart_id',
        'jumlah',
        'harga_beli',
        'harga_total',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'jumlah'      => 'integer',
        'harga_beli'  => 'decimal:2',
        'harga_total' => 'decimal:2',
        'tanggal'     => 'date',
    ];

    public function sparepart(): BelongsTo
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }
}
