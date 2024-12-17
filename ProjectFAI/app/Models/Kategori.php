<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';


    protected $fillable = [
        // Pastikan kamu memiliki kolom 'username' di tabel pegawai
        'nama_kategori',
        
   ];

   public $timestamps = false;
}
