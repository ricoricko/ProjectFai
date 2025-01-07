<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Menu;

class CartController extends Controller
{
    // Tambahkan item ke keranjang
    public function add(Request $request)
    {
       // Validasi input
    $validated = $request->validate([
        'id_menu' => 'required|integer',
        'jumlah' => 'required|integer|min:1',
    ]);

    // Ambil data keranjang dari sesi
    $cart = session()->get('cart', []);

    // Tambahkan item ke keranjang
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

    // Simpan keranjang kembali ke sesi
    session()->put('cart', $cart);

    // Redirect kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Item added to cart!');
    }

    // Lihat keranjang menggunakan payment.blade
    public function viewCart()
    {
        $cartItems = Cart::where('id_user', Auth::id())
                         ->where('status', 1)
                         ->with('menu')
                         ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->menu->harga_menu;
        });

        return view('payment', compact('cartItems', 'total'));
    }

    // Update jumlah item dalam keranjang
    public function updateCart(Request $request)
    {
        $request->validate([
            'id_cart' => 'required|exists:cart,id_cart',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = Cart::find($request->id_cart);
        $cart->jumlah = $request->jumlah;
        $cart->save();

        return redirect()->back()->with('success', 'Cart updated!');
    }

    // Hapus item dari keranjang
    public function removeFromCart($id)
    {
        $cart = Cart::find($id);

        if ($cart && $cart->id_user == Auth::id()) {
            $cart->delete();
            return redirect()->back()->with('success', 'Item removed from cart!');
        }

        return redirect()->back()->with('error', 'Item not found!');
    }
    public function checkout()
{
    $cartItems = Cart::where('id_user', Auth::id())
                     ->where('status', 1)
                     ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong!');
    }

    // Proses checkout logika di sini
    foreach ($cartItems as $item) {
        $item->status = 0; // Tandai sebagai checkout
        $item->save();
    }

    return redirect()->route('cart.view')->with('success', 'Checkout berhasil!');
}

}
