<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returnfood extends Model
{
    use HasFactory;

    protected $table = 'return';
    public $timestamps = false;
    protected $primaryKey='id';
    protected $fillable = [
        'id_nota',
        'id_menu',
        'jumlah',
        'harga',
        'alasan'
    ];
    public function menu()
   {
       return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
   }
}
