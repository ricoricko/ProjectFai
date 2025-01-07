<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function add(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_menu' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Ambil id_user dari sesi (jika ada)
        $idUser = Session::get('id_user');

        if ($idUser) {
            // Jika user login, simpan ke database
            DB::table('cart')->insert([
                'id_user' => $idUser,
                'id_menu' => $validated['id_menu'],
                'jumlah' => $validated['jumlah'],
                'status' => 1, // 1 berarti belum checkout
            ]);
        } else {
            // Jika user tidak login, simpan ke sesi
            $cart = session()->get('cart', []);

            $menuId = $validated['id_menu'];
            $jumlah = $validated['jumlah'];

            if (isset($cart[$menuId])) {
                $cart[$menuId]['jumlah'] += $jumlah;
            } else {
                $cart[$menuId] = [
                    'id_menu' => $menuId,
                    'jumlah' => $jumlah,
                ];
            }

            // Simpan data kembali ke sesi
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function viewCart()
{
    $idUser = Session::get('id_user'); // Pastikan session ini sudah diset saat login

    if (!$idUser) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    $cartItems = Cart::with('menu')
        ->where('id_user', $idUser)
        ->where('status', 1)
        ->get();

    $total = $cartItems->sum(function ($item) {
        return $item->jumlah * ($item->menu->harga_menu ?? 0);
    });

    return view('payment', compact('cartItems', 'total', 'idUser')); // Pastikan $idUser dikirim ke view
}

    


    // Update jumlah item dalam keranjang
    public function updateCart(Request $request)
    {
        $idUser = Session::get('id_user');

        if (!$idUser) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate([
            'id_cart' => 'required|exists:cart,id_cart',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::table('cart')
            ->where('id_cart', $request->id_cart)
            ->where('id_user', $idUser)
            ->update(['jumlah' => $request->jumlah]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    // Hapus item dari keranjang
    public function removeFromCart($id)
    {
        $idUser = Session::get('id_user');

        if (!$idUser) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        DB::table('cart')
            ->where('id_cart', $id)
            ->where('id_user', $idUser)
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    // Checkout keranjang
    public function checkout()
    {
        $idUser = Session::get('id_user');

        if (!$idUser) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $cartItems = DB::table('cart')
            ->where('id_user', $idUser)
            ->where('status', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong!');
        }

        // Tandai item sebagai checkout
        DB::table('cart')
            ->where('id_user', $idUser)
            ->where('status', 1)
            ->update(['status' => 0]);

        return redirect()->route('cart.view')->with('success', 'Checkout berhasil!');
    }
}
