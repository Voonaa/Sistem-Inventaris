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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
            $table->foreignId('sub_kategori_id')->nullable()->constrained('sub_kategoris')->onDelete('set null');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->enum('kondisi', ['baik', 'kurang_baik', 'rusak'])->default('baik');
            $table->enum('status', ['tersedia', 'dipinjam', 'maintenance'])->default('tersedia');
            $table->string('lokasi')->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->enum('sumber', ['pembelian', 'hibah', 'lainnya'])->default('pembelian');
            $table->decimal('harga', 12, 2)->nullable();
            $table->integer('stok')->default(1);
            $table->string('foto')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
