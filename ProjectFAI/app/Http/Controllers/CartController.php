<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
    }

    $validated = $request->validate([
        'id_menu' => 'required|exists:menu,id_menu',
        'jumlah' => 'required|integer|min:1',
    ]);

    $userId = Auth::id();

    $existingCart = Cart::where('id_user', $userId)
                        ->where('id_menu', $validated['id_menu'])
                        ->first();

    if ($existingCart) {
        $existingCart->jumlah += $validated['jumlah'];
        $existingCart->save();
    } else {
        Cart::create([
            'id_user' => $userId,
            'id_menu' => $validated['id_menu'],
            'jumlah' => $validated['jumlah'],
            'status' => 1,
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Item berhasil ditambahkan ke keranjang.']);
}


    public function show()
    {
        $userId = Auth::id();

        $cartItems = Cart::where('id_user', $userId)
                         ->with('menu') 
                         ->get();

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id_cart' => 'required|exists:cart,id_cart',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = Cart::find($validated['id_cart']);
        $cart->jumlah = $validated['jumlah'];
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah item berhasil diperbarui',
        ]);
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'id_cart' => 'required|exists:cart,id_cart',
        ]);

        $cart = Cart::find($validated['id_cart']);
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari keranjang',
        ]);
    }
}
