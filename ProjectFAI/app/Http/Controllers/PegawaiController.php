<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $cart = Cart::where('cart.status', 1)
                    ->join('users', 'cart.id_user', '=', 'users.id_user')
                    ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
                    ->select('cart.*', 'users.nama as user_name', 'menu.nama_menu as product_name')
                    ->get()
                    ->groupBy('user_name'); // Group by user_name in the controller
        $produk = Produk::all();
        return view('pegawai', compact('cart','produk'));
    }

    public function confirm(Request $request)
    {
        Cart::where('id_user', $request->user_id)
            ->where('status', 1)
            ->update(['status' => 0]); // Mark all as confirmed for the user

        return redirect()->route('pegawai.index');
    }
}
?>
