<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function __construct()
    {
        // Middleware, jika diperlukan
        // $this->middleware('auth');

        // Atau inisialisasi variabel tertentu
        $this->middleware(function ($request, $next) {
            Session::put('id_user', Session::get('id_user', null)); // Set default ID user jika session belum ada
            return $next($request);
        });
    }
    public function index()
{
    $categories = DB::select('SELECT * FROM kategori');

    $menus = DB::select('SELECT * FROM menu');

    $username = Session::get('username', null);
    $id_user = Session::get('id_user', null);

    return view('menu', compact('categories', 'menus', 'username'));
}

}
