<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Import Session

class PegawaiController extends Controller
{
    public function index()
    {
        $logged_in_employee = Session::get('pegawai_name'); // Get the logged-in employee's name

        $cart = Cart::where('cart.status', 0)
                    ->join('users', 'cart.id_user', '=', 'users.id_user')
                    ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
                    ->select('cart.*', 'users.nama as user_name', 'menu.nama_menu as product_name')
                    ->get()
                    ->groupBy('user_name'); // Group by user_name in the controller
        $produk = Produk::all();
        return view('pegawai', compact('cart', 'produk', 'logged_in_employee'));
    }

    public function confirm(Request $request)
    {
        // Update the cart status
        Cart::where('id_user', $request->user_id)
            ->where('status', 0)
            ->update(['status' => 2]); // Mark all as confirmed for the user

        // Increment jumlah_confirm for the logged-in employee
        $pegawai_id = Session::get('pegawai_id');
        $pegawai = Pegawai::find($pegawai_id);
        $pegawai->jumlah_confirm = $pegawai->jumlah_confirm + 1; // Increment the jumlah_confirm
        $pegawai->save();

        return redirect()->route('pegawai.index');
    }
}
?>
