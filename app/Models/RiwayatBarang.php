<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatBarang extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buku_id',
        'barang_id',
        'jenis_aktivitas',
        'jumlah',
        'jumlah_sebelum',
        'jumlah_sesudah',
        'keterangan',
        'user_id',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah' => 'integer',
        'jumlah_sebelum' => 'integer',
        'jumlah_sesudah' => 'integer',
    ];
    
    /**
     * Get the buku that owns the riwayat barang.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
    
    /**
     * Get the barang that owns the riwayat barang.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
    
    /**
     * Get the user that owns the riwayat barang.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
