<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->decimal('harga_beli', 15, 2)->default(0)->after('jumlah');
            $table->decimal('harga_total', 15, 2)->default(0)->after('harga_beli');
        });
    }

    public function down(): void
    {
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->dropColumn(['harga_beli', 'harga_total']);
        });
    }
};
