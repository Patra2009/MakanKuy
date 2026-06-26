<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    /**
     * Get menus for the kategori.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
