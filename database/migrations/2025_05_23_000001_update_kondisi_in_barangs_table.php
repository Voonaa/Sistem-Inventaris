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
        // Get the current kondisi values and store them temporarily
        $barangs = DB::table('barangs')->select('id', 'kondisi')->get();
        
        // Modify the column from enum to string
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('kondisi', 20)->nullable()->change();
        });
        
        // Update any lowercase values to proper case
        DB::table('barangs')->where('kondisi', 'baik')->update(['kondisi' => 'Baik']);
        DB::table('barangs')->where('kondisi', 'kurang_baik')->update(['kondisi' => 'Kurang Baik']);
        DB::table('barangs')->where('kondisi', 'rusak')->update(['kondisi' => 'Rusak']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We can't reliably convert back to the original enum without potentially losing data
        // So in this case, we'll just leave it as a string field
    }
}; 