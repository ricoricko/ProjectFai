<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPegawai extends Model
{
    use HasFactory;
    protected $table = 'transaksi_pegawai';
    protected $fillable = ['id_cashout', 'id_pegawai'];
    public $timestamps = false;

}
