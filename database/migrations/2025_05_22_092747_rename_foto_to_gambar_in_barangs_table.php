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
        Schema::table('barangs', function (Blueprint $table) {
            // Check if foto column exists and gambar doesn't
            if (Schema::hasColumn('barangs', 'foto') && !Schema::hasColumn('barangs', 'gambar')) {
                $table->renameColumn('foto', 'gambar');
            } 
            // If gambar doesn't exist and foto doesn't exist either, create gambar
            elseif (!Schema::hasColumn('barangs', 'gambar') && !Schema::hasColumn('barangs', 'foto')) {
                $table->string('gambar')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'gambar')) {
                $table->renameColumn('gambar', 'foto');
            }
        });
    }
};
