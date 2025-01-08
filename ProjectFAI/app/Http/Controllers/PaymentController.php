<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function checkout()
{
    $idUser = Session::get('id_user');

    if (!$idUser) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Ambil data user dari tabel users
    $user = DB::table('users')->where('id_user', $idUser)->first();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Data pengguna tidak ditemukan.');
    }

    // Pecahkan nama menjadi first_name dan last_name
    $nama = $user->nama ?? 'Guest User';
    $namaArray = explode(' ', trim($nama));
    $firstName = $namaArray[0] ?? 'Guest';
    $lastName = isset($namaArray[1]) ? implode(' ', array_slice($namaArray, 1)) : $firstName;

    // Ambil item dari cart
    $cartItems = DB::table('cart')
        ->select('menu.id_menu', 'menu.nama_menu', 'menu.harga_menu', 'cart.jumlah', 'menu.image_menu', 'cart.id_cart', 'stok.jumlah_stok')
        ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
        ->join('stok', 'menu.id_menu', '=', 'stok.id_stok')
        ->where('cart.id_user', $idUser)
        ->where('cart.status', 1)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong!');
    }

    $total = $cartItems->sum(function ($item) {
        return $item->jumlah * $item->harga_menu;
    });

    // Buat data transaksi untuk Midtrans
    $transactionData = [
        'transaction_details' => [
            'order_id' => 'order-' . time(),
            'gross_amount' => $total,
        ],
        'item_details' => $cartItems->map(function ($item) {
            return [
                'id' => $item->id_menu,
                'price' => $item->harga_menu,
                'quantity' => $item->jumlah,
                'name' => $item->nama_menu,
            ];
        })->toArray(),
        'customer_details' => [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $user->email ?? 'email@example.com',
            'phone' => $user->phone ?? '08123456789',
        ],
    ];

    // Konfigurasi Midtrans
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') == 'true';
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($transactionData);
    } catch (\Exception $e) {
        return redirect()->route('cart.view')->with('error', 'Gagal mendapatkan Snap Token: ' . $e->getMessage());
    }

    return view('payment', [
        'cartItems' => $cartItems,
        'total' => $total,
        'snapToken' => $snapToken,
        'userId' => $idUser,
    ]);
}

}
