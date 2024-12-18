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
        'nama_kategori',
        
   ];
   public function menus()
   {
       return $this->hasMany(Menu::class, 'kategori_menu', 'id_kategori');
   }
   public $timestamps = false;
}
