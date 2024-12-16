<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        // Pastikan kamu memiliki kolom 'username' di tabel pegawai
        'nama_produk',
        'harga',
        'stok',
        'status',
        
   ];

   public $timestamps = false;

}
