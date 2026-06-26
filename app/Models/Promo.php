<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';

    protected $fillable = [
        'judul', 'deskripsi', 'diskon', 'tanggal_mulai', 'tanggal_akhir', 'gambar', 'status'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_akhir' => 'date',
        ];
    }
}
