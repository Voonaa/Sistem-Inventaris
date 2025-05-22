<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'barang_id',
        'buku_id',
        'peminjam',
        'jenis',
        'kelas',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'catatan',
        'denda',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikembalikan' => 'date',
        'jumlah' => 'integer',
        'denda' => 'decimal:2',
    ];
    
    /**
     * Get the user that owns the peminjaman.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the buku that belongs to the peminjaman.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
    
    /**
     * Get the barang that belongs to the peminjaman.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
    
    /**
     * Scope a query to only include overdue peminjaman.
     */
    public function scopeOverdue($query)
    {
        return $query->whereNull('tanggal_dikembalikan')
                     ->where('tanggal_kembali', '<', now())
                     ->where('status', 'dipinjam');
    }
    
    /**
     * Calculate denda based on days overdue.
     */
    public function calculateDenda($dendaPerHari = 1000)
    {
        if ($this->status !== 'terlambat' || $this->tanggal_dikembalikan) {
            return 0;
        }
        
        $daysLate = now()->diffInDays($this->tanggal_kembali, false);
        return max(0, $daysLate) * $dendaPerHari;
    }
}
