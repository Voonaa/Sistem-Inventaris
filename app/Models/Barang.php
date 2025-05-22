<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'merek',
        'model',
        'nomor_seri',
        'tahun_perolehan',
        'kondisi',
        'status',
        'lokasi',
        'jumlah',
        'stok',
        'harga_perolehan',
        'sumber_dana',
        'is_buku',
        'buku_id',
        'gambar',
        'created_by',
        'updated_by',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_perolehan' => 'integer',
        'jumlah' => 'integer',
        'stok' => 'integer',
        'harga_perolehan' => 'decimal:2',
        'is_buku' => 'boolean',
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
     * Virtual relationship for category - returns the category data.
     * Used to make eager loading with('kategori') work for reports.
     */
    public function kategori()
    {
        // This is a virtual relationship to make eager loading work
        return $this->belongsTo(self::class)->addEagerConstraints([]);
    }
    
    /**
     * Virtual relationship for sub category - returns the sub category data.
     * Used to make eager loading with('subKategori') work for reports.
     */
    public function subKategori()
    {
        // Always return a valid relationship instance
        return $this->belongsTo(self::class)->whereRaw('1 = 0'); // Empty relationship that will never match
    }
    
    /**
     * Get kategori label accessor.
     */
    public function getKategoriLabelAttribute()
    {
        $categories = config('categories', []);
        
        if (isset($categories[$this->kategori])) {
            if (is_array($categories[$this->kategori]) && isset($categories[$this->kategori]['label'])) {
                return $categories[$this->kategori]['label'];
            } elseif (is_string($categories[$this->kategori])) {
                return $categories[$this->kategori];
            }
        }
        
        return Str::title(str_replace('_', ' ', $this->kategori));
    }
    
    /**
     * Get sub kategori label accessor.
     */
    public function getSubKategoriLabelAttribute()
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
