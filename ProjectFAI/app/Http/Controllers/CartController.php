<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function add(Request $request)
{
    $request->validate([
        'id_menu' => 'required|integer',
        'jumlah' => 'required|integer|min:1',
    ]);

    $idUser = Session::get('id_user');

    if ($idUser) {
        // Tambahkan ke database jika user sudah login
        DB::table('cart')->insert([
            'id_user' => $idUser,
            'id_menu' => $request->id_menu,
            'jumlah' => $request->jumlah,
            'status' => 1, // Belum checkout
        ]);
    } else {
        // Tambahkan ke session jika user belum login
        $cart = session()->get('cart', []);
        $menuId = $request->id_menu;
        $jumlah = $request->jumlah;

        if (isset($cart[$menuId])) {
            $cart[$menuId]['jumlah'] += $jumlah;
        } else {
            $cart[$menuId] = ['id_menu' => $menuId, 'jumlah' => $jumlah];
        }

        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');

}


public function viewCart()
{
    // Ambil data user dari session
    $userId = Session::get('id_user');

    // Pastikan session id_user ada
    if (!$userId) {
        // Jika tidak ada, redirect ke halaman login
        return redirect()->route('login')->with('error', 'Harap login untuk melihat keranjang.');
    }

    // Ambil data cart berdasarkan id_user dari session
    $cartItems = DB::table('cart')
        ->select('menu.nama_menu', 'menu.harga_menu', 'cart.jumlah', 'menu.image_menu', 'cart.id_cart')
        ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
        ->where('cart.id_user', $userId)
        ->where('cart.status', 1) // Pastikan hanya menampilkan barang dengan status aktif
        ->get();

    // Cek jika cartItems kosong
    if ($cartItems->isEmpty()) {
        return view('payment', [
            'cartItems' => [],
            'message' => 'Keranjang Anda kosong.',
            'userId' => $userId,
        ]);
    }

    // Hitung total harga
    $total = $cartItems->sum(function($item) {
        return $item->jumlah * $item->harga_menu;
    });

    // Kirim data ke view
    return view('payment', [
        'cartItems' => $cartItems,
        'userId' => $userId,
        'total' => $total,
    ]);
}





    // Update jumlah item dalam keranjang
    public function updateCart(Request $request)
{
    $idUser  = Session::get('id_user');

    if (!$idUser ) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    $request->validate([
        'id_cart' => 'required|exists:cart,id_cart',
        'jumlah' => 'required|integer|min:1',
    ]);

    DB::table('cart')
        ->where('id_cart', $request->id_cart)
        ->where('id_user', $idUser )
        ->update(['jumlah' => $request->jumlah]);

    return redirect()->back()->with('success', 'Jumlah item di keranjang telah diperbarui!');
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
