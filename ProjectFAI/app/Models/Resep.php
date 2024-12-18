<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'resep';

    protected $fillable = [
        // Pastikan kamu memiliki kolom 'username' di tabel pegawai
        'id_menu',
        'id_produk',
        'stok',

   ];

   public $timestamps = false;
   public function menus()
   {
       return $this->hasMany(Menu::class, 'id_menu', 'id_menu');
   }
}
