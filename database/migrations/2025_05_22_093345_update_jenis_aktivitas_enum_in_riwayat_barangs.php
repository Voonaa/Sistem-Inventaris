<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL way: modify the enum to include 'hapus'
        DB::statement("ALTER TABLE riwayat_barangs MODIFY COLUMN jenis_aktivitas ENUM('tambah', 'kurang', 'penyesuaian', 'peminjaman', 'pengembalian', 'perbaikan', 'hapus')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum without 'hapus'
        DB::statement("ALTER TABLE riwayat_barangs MODIFY COLUMN jenis_aktivitas ENUM('tambah', 'kurang', 'penyesuaian', 'peminjaman', 'pengembalian', 'perbaikan')");
    }
};
