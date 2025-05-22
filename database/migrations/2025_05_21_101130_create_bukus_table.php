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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
            $table->foreignId('sub_kategori_id')->nullable()->constrained('sub_kategoris')->onDelete('set null');
            $table->string('kode_barang')->unique();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('isbn')->nullable();
            $table->integer('jumlah_halaman');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['pelajaran', 'fiksi', 'non-fiksi', 'referensi', 'lainnya'])->default('pelajaran');
            $table->string('lokasi_rak');
            $table->integer('stok')->default(1);
            $table->integer('dipinjam')->default(0);
            $table->enum('kondisi', ['baik', 'kurang_baik', 'rusak'])->default('baik');
            $table->enum('status', ['available', 'borrowed', 'maintenance'])->default('available');
            $table->date('tanggal_perolehan')->nullable();
            $table->enum('sumber', ['pembelian', 'hibah', 'lainnya'])->default('pembelian');
            $table->decimal('harga', 12, 2)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
