<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey='id_menu';
    protected $fillable = [
        'nama_menu',
        'kategori_menu',
        'harga_menu',
        'image_menu',
    ];
    public $timestamps = false;
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_menu', 'id_kategori');
    }
    public function Resep()
    {
        return $this->belongsTo(Resep::class, 'id_menu', 'id_menu');
    }
}
