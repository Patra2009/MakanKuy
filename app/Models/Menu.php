<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'kategori_id', 'nama', 'gambar', 'deskripsi', 'harga', 'stok'
    ];

    /**
     * Get the kategori that owns the menu.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Get detail pesanans for the menu.
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
