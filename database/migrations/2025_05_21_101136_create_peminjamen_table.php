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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('buku_id')->nullable()->constrained('bukus')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->string('peminjam')->nullable(); // Optional field for peminjam name
            $table->string('jenis')->nullable(); // Optional field for categorization
            $table->string('kelas')->nullable(); // Optional field for class/grade
            $table->integer('jumlah')->default(1); // Number of items borrowed
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->text('catatan')->nullable();
            $table->decimal('denda', 10, 2)->default(0);
            
            // Note: We've removed the check constraint that was causing issues
            // Instead, we'll enforce the rule through application logic
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
