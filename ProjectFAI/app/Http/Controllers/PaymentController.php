<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function paymentSuccess(Request $request)
    {
        $idUser  = Session::get('id_user');
    
        if (!$idUser ) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        $cartItems = DB::table('cart')
            ->join('menu', 'cart.id_menu', '=', 'menu.id_menu') 
            ->where('cart.id_user', $idUser )
            ->where('cart.status', 1)
            ->select('cart.*', 'menu.harga_menu', 'menu.nama_menu') 
            ->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong!');
        }
    
        foreach ($cartItems as $item) {
            $stok = DB::table('stok')->where('id_stok', $item->id_menu)->first();
            if ($item->jumlah > $stok->jumlah_stok) {
                return redirect()->route('cart.view')->with('error', 'Stok tidak cukup untuk item: ' . $item->nama_menu);
            }
    
            DB::table('stok')
                ->where('id_stok', $item->id_menu)
                ->decrement('jumlah_stok', $item->jumlah);
        }
    
        foreach ($cartItems as $item) {
            DB::table('transaksi')->insert([
                'id_user' => $idUser ,
                'id_menu' => $item->id_menu,
                'jumlah' => $item->jumlah,
                'tanggal' => now(),
                'total_harga' => $item->jumlah * $item->harga_menu, 
            ]);
        }
    
        DB::table('cart')
            ->where('id_user', $idUser )
            ->where('status', 1)
            ->update(['status' => 0]);
    
        return view('payment-success');
    }
    public function checkout()
{
    $idUser = Session::get('id_user');
    if (!$idUser) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    $user = DB::table('users')->where('id_user', $idUser)->first();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Data pengguna tidak ditemukan.');
    }

    $cartItems = DB::table('cart')
        ->join('menu', 'cart.id_menu', '=', 'menu.id_menu')
        ->where('cart.id_user', $idUser)
        ->where('cart.status', 1)
        ->select('cart.*', 'menu.harga_menu', 'menu.nama_menu', 'menu.image_menu')
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong!');
    }

    $total = $cartItems->sum(fn($item) => $item->jumlah * $item->harga_menu);

    $totalPengeluaran = DB::table('transaksi')
    ->where('id_user', $idUser)

    ->sum('total_harga'); 


    $currentMember = DB::table('member')
    ->join('jenis_member', 'member.id_jenismember', '=', 'jenis_member.id_jenismember')
    ->where('member.id_user', $idUser)
    ->select('jenis_member.potongan', 'jenis_member.nama as jenis_member', 'jenis_member.id_jenismember')
    ->first();


    if (!$currentMember) {
        $eligibleMembership = DB::table('jenis_member')
        ->where('minimum_transaksi', '<=', $totalPengeluaran)
        ->orderBy('minimum_transaksi', 'desc')
        ->first();
    
   
    

        if ($eligibleMembership) {
            DB::table('member')->insert([
                'id_user' => $idUser,
                'id_jenismember' => $eligibleMembership->id_jenismember, 
            ]);
        
            $currentMember = DB::table('jenis_member')
                ->where('id_jenismember', $eligibleMembership->id_jenismember)
                ->select('nama as jenis_member', 'potongan')
                ->first();
        }
        
    } else {
        $eligibleMembership = DB::table('jenis_member')
            ->where('minimum_transaksi', '<=', $totalPengeluaran)
            ->orderBy('minimum_transaksi', 'desc')
            ->first();

            if ($eligibleMembership && $eligibleMembership->id_jenismember > $currentMember->id_jenismember) {
                DB::table('member')
                    ->where('id_user', $idUser)
                    ->update(['id_jenismember' => $eligibleMembership->id_jenismember]);
            

            $currentMember = DB::table('jenis_member')
                ->where('id_jenismember', $eligibleMembership->id_jenismember)
                ->select('nama as jenis_member', 'potongan')
                ->first();
        }
    }

    $discount = $currentMember->potongan ?? 0;
    $finalTotal = $total - ($total * ($discount / 100));

    $transactionData = [
       'transaction_details' => [
    'order_id' => 'order-' . time(),
    'gross_amount' => $finalTotal,  
    'original_amount' => $total, 
],

        'item_details' => array_merge($cartItems->map(function ($item) {
    return [
        'id' => $item->id_menu,
        'price' => $item->harga_menu,
        'quantity' => $item->jumlah,
        'name' => $item->nama_menu,
    ];
})->toArray(), [
    [
        'id' => 'discount',
        'price' => -($total * ($discount / 100)),
        'quantity' => 1,
        'name' => 'Discount',
    ],
]),

    ];

    Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') == 'true';
    Config::$isSanitized = true;
    Config::$is3ds = true;

    try {
        $snapToken = Snap::getSnapToken($transactionData);
    } catch (\Exception $e) {
        return redirect()->route('cart.view')->with('error', 'Gagal mendapatkan Snap Token: ' . $e->getMessage());
    }

    return view('payment', compact('cartItems', 'total', 'finalTotal', 'snapToken', 'user', 'currentMember', 'discount'));
}

}
