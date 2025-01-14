<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
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

        $totalPengeluaran = DB::table('htrans_order')
            ->where('id_user', $idUser)
            ->sum('subtotal');

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

        $cartItems = $cartItems->map(function ($item) use ($discount) {
            $item->harga_diskon = $item->harga_menu - ($item->harga_menu * ($discount / 100));
            return $item;
        });

        $finalTotal = $cartItems->sum(fn($item) => $item->jumlah * $item->harga_diskon);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') == 'true';
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $transactionData = [
            'transaction_details' => [
                'order_id' => 'order-' . time(),
                'gross_amount' => $finalTotal,
            ],
            'item_details' => $cartItems->map(function ($item) {
                return [
                    'id' => $item->id_menu,
                    'price' => $item->harga_diskon,
                    'quantity' => $item->jumlah,
                    'name' => $item->nama_menu,
                ];
            })->toArray(),
        ];

        try {
            $snapToken = Snap::getSnapToken($transactionData);
        } catch (\Exception $e) {
            return redirect()->route('cart.view')->with('error', 'Gagal mendapatkan Snap Token: ' . $e->getMessage());
        }

        Session::put('pending_transaction', [
            'order_id' => $transactionData['transaction_details']['order_id'],
            'cart_items' => $cartItems,
            'total' => $finalTotal,
        ]);

        return view('payment', compact('cartItems', 'total', 'finalTotal', 'snapToken', 'user', 'currentMember', 'discount'));
    }

    public function paymentCallback(Request $request)
    {
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $transactionStatus = $request->input('transaction_status');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . env('MIDTRANS_SERVER_KEY'));
        if ($calculatedSignature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if ($transactionStatus == 'settlement') {
            $this->processOrder($orderId);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            Session::forget('pending_transaction');
        }

        return response()->json(['message' => 'Callback processed'], 200);
    }

    public function paymentSuccess(Request $request)
    {
        $pendingTransaction = Session::get('pending_transaction');
        if (!$pendingTransaction) {
            return redirect()->route('cart.view')->with('error', 'Tidak ada transaksi yang ditemukan.');
        }

        $this->processOrder($pendingTransaction['order_id']);
        Session::forget('pending_transaction');

        return view('payment-success');
    }

    private function processOrder($orderId)
    {
        $pendingTransaction = Session::get('pending_transaction');
        if (!$pendingTransaction || $pendingTransaction['order_id'] !== $orderId) {
            return;
        }

        $idUser = Session::get('id_user');
        $cartItems = $pendingTransaction['cart_items'];
        $total = $pendingTransaction['total'];

        $htransId = DB::table('htrans_order')->insertGetId([
            'id_user' => $idUser,
            'subtotal' => $total,
            'tanggal' => now(),
        ]);

        foreach ($cartItems as $item) {
            DB::table('dtrans_order')->insert([
                'id_htrans' => $htransId,
                'id_menu' => $item->id_menu,
                'harga' => $item->harga_diskon,
                'jumlah' => $item->jumlah,
                'total' => $item->jumlah * $item->harga_diskon,
                'status' => 1,
            ]);

            DB::table('stok')
                ->where('id_stok', $item->id_menu)
                ->decrement('jumlah_stok', $item->jumlah);
        }

        DB::table('cash_in')->insert([
            'cash_in' => $total,
            'tanggal' => now(),
            'status' => 'transaksi pelanggan',
        ]);
        
        if (!DB::table('cash')->where('id_cash', 1)->exists()) {
            DB::table('cash')->insert([
                'id_cash' => 1,
                'jumlah_cash' => 0,
                'tanggal' => now(),
            ]);
        }
    
   
        DB::table('cash')
            ->where('id_cash', 1)
            ->update([
                'jumlah_cash' => DB::raw('jumlah_cash + ' . $total),
                'tanggal' => now(),
            ]);
        DB::table('cart')
            ->where('id_user', $idUser)
            ->where('status', 1)
            ->update(['status' => 0]);
    }
}
