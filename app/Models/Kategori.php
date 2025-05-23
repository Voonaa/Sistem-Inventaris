<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    
    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'icon',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori', 'kode');
    }
} 