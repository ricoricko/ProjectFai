<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dtrans extends Model
{
    use HasFactory;

    protected $table = 'dtrans_order';
    public $timestamps = false;

    protected $fillable = [
        'id_htrans',
        'id_menu',
        'harga',
        'jumlah',
        'total',
    ];
    public function menu()
   {
       return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
   }
}
