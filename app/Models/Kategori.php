<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'active',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
    ];
    
    /**
     * Get the sub-kategoris for the kategori.
     */
    public function subKategoris(): HasMany
    {
        return $this->hasMany(SubKategori::class);
    }
    
    /**
     * Get the barangs for the kategori.
     */
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
