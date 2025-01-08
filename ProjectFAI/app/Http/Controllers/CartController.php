<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Config;
use Midtrans\Snap;


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
        DB::table('cart')->insert([
            'id_user' => $idUser,
            'id_menu' => $request->id_menu,
            'jumlah' => $request->jumlah,
            'status' => 1, 
        ]);
    } else {
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

// public function checkout()
//     {
//         // Ambil data user dari session
//         $idUser = Session::get('id_user');
//         if (!$idUser) {
//             return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
//         }

//         // Ambil data user
//         $user = DB::table('users')->where('id_user', $idUser)->first();
//         if (!$user) {
//             return redirect()->route('login')->with('error', 'Data pengguna tidak ditemukan.');
//         }

//         // Pecahkan nama menjadi first_name dan last_name
//         $nama = $user->nama ?? 'Guest User';
//         $namaArray = explode(' ', trim($nama));
//         $firstName = $namaArray[0] ?? 'Guest';
//         $lastName = isset($namaArray[1]) ? implode(' ', array_slice($namaArray, 1)) : $firstName;

//         // Ambil item dari keranjang
//         $cartItems = DB::table('cart')
//             ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
//             ->where('cart.id_user', $idUser)
//             ->where('cart.status', 1)
//             ->get();

//         if ($cartItems->isEmpty()) {
//             return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong!');
//         }

//         $total = $cartItems->sum(fn($item) => $item->jumlah * $item->harga_menu);
//         $itemDetails = $cartItems->map(function ($item) {
//             return [
//                 'id' => $item->id_menu,
//                 'price' => $item->harga_menu,
//                 'quantity' => $item->jumlah,
//                 'name' => $item->nama_menu,
//             ];
//         })->toArray();

//         // Buat data transaksi untuk Midtrans
//         $transactionData = [
//             'transaction_details' => [
//                 'order_id' => 'order-' . time(),
//                 'gross_amount' => $total,
//             ],
//             'item_details' => $itemDetails,
//             'customer_details' => [
//                 'first_name' => $firstName,
//                 'last_name' => $lastName,
//                 'email' => $user->email ?? 'email@example.com',
//                 'phone' => $user->phone ?? '08123456789',
//             ],
//         ];

//         // Konfigurasi Midtrans
//         Config::$serverKey = env('MIDTRANS_SERVER_KEY');
//         Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') == 'true';
//         Config::$isSanitized = true;
//         Config::$is3ds = true;

//         try {
//             $snapToken = Snap::getSnapToken($transactionData);
//         } catch (\Exception $e) {
//             return redirect()->route('cart.view')->with('error', 'Gagal mendapatkan Snap Token: ' . $e->getMessage());
//         }

//         return view('payment', compact('cartItems', 'total', 'snapToken', 'user'));
//     }
public function viewCart()
{
    $userId = Session::get('id_user');

    if (!$userId) {
        return redirect()->route('login')->with('error', 'Harap login untuk melihat keranjang.');
    }

    $cartItems = DB::table('cart')
        ->select('menu.nama_menu', 'menu.harga_menu', 'cart.jumlah', 'menu.image_menu', 'cart.id_cart')
        ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
        ->where('cart.id_user', $userId)
        ->where('cart.status', 1) 
        ->get();

    if ($cartItems->isEmpty()) {
        return view('payment', [
            'cartItems' => [],
            'message' => 'Keranjang Anda kosong.',
            'userId' => $userId,
        ]);
    }

    $total = $cartItems->sum(function($item) {
        return $item->jumlah * $item->harga_menu;
    });

    return view('payment', [
        'cartItems' => $cartItems,
        'userId' => $userId,
        'total' => $total,
    ]);
}





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

    
}
