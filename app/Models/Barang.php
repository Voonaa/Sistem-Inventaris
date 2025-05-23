<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Barang extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'kategori',
        'sub_kategori',
        'kondisi',
        'status',
        'lokasi',
        'stok',
        'harga_perolehan',
        'sumber_dana',
        'foto'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stok' => 'integer',
        'harga_perolehan' => 'decimal:2'
    ];
    
    /**
     * Appends these accessor attributes to every query.
     */
    protected $appends = ['kategori_label', 'sub_kategori_label'];
    
    /**
     * Get the buku associated with the barang.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
    
    /**
     * Get the peminjamans for the barang.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
    
    /**
     * Get the riwayat barangs for the barang.
     */
    public function riwayatBarangs(): HasMany
    {
        return $this->hasMany(RiwayatBarang::class);
    }
    
    /**
     * Get the user who created the barang.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Get the user who last updated the barang.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    /**
     * Get kategori label accessor.
     */
    public function getKategoriLabelAttribute(): string
    {
        $categories = config('categories', []);
        
        if (isset($categories[$this->kategori])) {
            if (is_array($categories[$this->kategori]) && isset($categories[$this->kategori]['label'])) {
                return $categories[$this->kategori]['label'];
            } elseif (is_string($categories[$this->kategori])) {
                return $categories[$this->kategori];
            }
        }
        
        return Str::title(str_replace('_', ' ', $this->kategori ?? 'Tidak Ada Kategori'));
    }
    
    /**
     * Get sub kategori label accessor.
     */
    public function getSubKategoriLabelAttribute(): ?string
    {
        if (!$this->sub_kategori) {
            return null;
        }
        
        $categories = config('categories', []);
        
        if ($this->kategori === 'perpustakaan' && 
            isset($categories[$this->kategori]['sub'][$this->sub_kategori])) {
            return $categories[$this->kategori]['sub'][$this->sub_kategori];
        }
        
        return Str::title(str_replace('_', ' ', $this->sub_kategori));
    }
}
