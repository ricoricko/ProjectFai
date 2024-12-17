<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{

    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
         // Pastikan kamu memiliki kolom 'username' di tabel pegawai
         'nama_pegawai',
         'alamat_pegawai',
         'status_pegawai',
         'password_pegawai',
         'gaji_pegawai',
    ];

    public $timestamps = false;


}
