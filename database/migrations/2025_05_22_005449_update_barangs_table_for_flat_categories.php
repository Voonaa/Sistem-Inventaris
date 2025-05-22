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
        Schema::table('barangs', function (Blueprint $table) {
            // Add new string columns for kategori and sub_kategori
            $table->string('kategori')->nullable()->after('deskripsi');
            $table->string('sub_kategori')->nullable()->after('kategori');
        });

        // Migrate data from foreign keys to string values
        DB::statement("
            UPDATE barangs b
            LEFT JOIN kategoris k ON b.kategori_id = k.id
            LEFT JOIN sub_kategoris s ON b.sub_kategori_id = s.id
            SET 
                b.kategori = COALESCE(LOWER(REPLACE(k.nama, ' ', '_')), 'data_umum'),
                b.sub_kategori = CASE 
                    WHEN k.nama LIKE '%Perpustakaan%' THEN COALESCE(LOWER(REPLACE(s.nama, ' ', '_')), 'buku_umum')
                    ELSE NULL
                END
        ");

        // Drop foreign keys first
        Schema::table('barangs', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['sub_kategori_id']);
        });

        // Then drop columns
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['kategori_id', 'sub_kategori_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Add back the foreign key columns
            $table->unsignedBigInteger('kategori_id')->nullable()->after('deskripsi');
            $table->unsignedBigInteger('sub_kategori_id')->nullable()->after('kategori_id');
            
            // Drop the string columns
            $table->dropColumn(['kategori', 'sub_kategori']);
        });
    }
};
