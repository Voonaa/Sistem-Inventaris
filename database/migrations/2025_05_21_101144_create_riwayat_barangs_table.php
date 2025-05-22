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
        Schema::create('riwayat_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->nullable()->constrained('bukus')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->enum('jenis_aktivitas', ['tambah', 'kurang', 'penyesuaian', 'peminjaman', 'pengembalian', 'perbaikan']);
            $table->integer('jumlah');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Note: We've removed the check constraint to fix the migration issue
            // This validation should be handled at the application level
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_barangs');
    }
};
