<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Dtrans;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pegawai;
use App\Models\Produk;
use App\Models\User;
use App\Models\Resep;
use App\Models\Returnfood;
use App\Models\TransaksiPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class ManagerController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $produk = Produk::all();
        return view('admin', compact('pegawai','produk'));
    }


    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->update($request->all());
        return redirect()->route('admin.index')->with('success', 'Data Pegawai berhasil diupdate.');
    }



    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->delete();
        return redirect()->route('admin.index')->with('success', 'Data Pegawai berhasil dihapus.');
    }

    public function create()
    {
        return view('CreatePegawai');
    }
    public function store(Request $request)
    {
        Pegawai::create($request->all());
        return redirect()->route('admin.index')->with('success', 'Data Pegawai berhasil ditambahkan.');
    }
    public function addProduk(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        try {
            \DB::transaction(function () use ($request) {
                $hargaTotal = $request->input('harga') * $request->input('stok');

                $latestCash = \DB::table('cash')->latest('id_cash')->first();

                if ($latestCash->jumlah_cash < $hargaTotal) {
                    throw new \Exception('Jumlah cash tidak mencukupi.');
                }

                $newCashAmount = $latestCash->jumlah_cash - $hargaTotal;
                \DB::table('cash')->where('id_cash', $latestCash->id_cash)->update(['jumlah_cash' => $newCashAmount]);

                \DB::table('cash_out')->insert([
                    'cash_out' => $hargaTotal,
                    'tanggal' => now(),
                ]);

                \DB::table('produk')->insert([
                    'nama_produk' => $request->input('nama_produk'),
                    'harga' => $request->input('harga'),
                    'stok' => $request->input('stok'),
                    'status' => 1,
                ]);
            });

            return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.produk')->with('error', $e->getMessage());
        }
    }



    // public function addProduk(Request $request)
    // {
    //     Produk::create($request->all());
    //     return redirect()->route('admin.produk')->with('success', 'Data Produk berhasil ditambahkan.');
    // }
    // public function updateProduk(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_produk' => 'required|string|max:255',
    //         'harga' => 'required|numeric',
    //         'stok' => 'required|numeric',
    //     ]);

    //     $produk = Produk::findOrFail($id);
    //     $produk->update([
    //         'nama_produk' => $request->input('nama_produk'),
    //         'harga' => $request->input('harga'),
    //         'stok' => $request->input('stok'),
    //     ]);

    //     return redirect()->route('admin.produk')->with('success', 'Data Produk berhasil diupdate.');
    // }
    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        try {
            \DB::transaction(function () use ($request, $id) {
                $produk = \DB::table('produk')->where('id_produk', $id)->first();
                $stokSekarang = $produk->stok;
                $stokBaru = $request->input('stok');
                $hargaBaru = $request->input('harga');

                // Calculate the stock difference
                $stokDifference = $stokBaru - $stokSekarang;

                // Check if adding more stock
                if ($stokDifference > 0) {
                    $hargaTotal = $stokDifference * $hargaBaru;

                    $latestCash = \DB::table('cash')->latest('id_cash')->first();

                    if ($latestCash->jumlah_cash < $hargaTotal) {
                        throw new \Exception('Jumlah cash tidak mencukupi.');
                    }

                    $newCashAmount = $latestCash->jumlah_cash - $hargaTotal;
                    \DB::table('cash')->where('id_cash', $latestCash->id_cash)->update(['jumlah_cash' => $newCashAmount]);

                    \DB::table('cash_out')->insert([
                        'cash_out' => $hargaTotal,
                        'tanggal' => now(),
                    ]);
                }

                \DB::table('produk')->where('id_produk', $id)->update([
                    'nama_produk' => $request->input('nama_produk'),
                    'harga' => $hargaBaru,
                    'stok' => $stokBaru,
                ]);
            });

            return redirect()->route('admin.produk')->with('success', 'Data Produk berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->route('admin.produk')->with('error', $e->getMessage());
        }
    }

    public function indexProduk(){
        $produk = Produk::all();
        return view('produk', compact('produk'));
    }
    public function indexMenu(){
        $produk = Produk::all();
        $kategori = Kategori::all();
        return view('adminMenu', compact('produk','kategori'));
    }


    public function addMenu(Request $request){
        // Validate the request data
        // $request->validate([
        //     'nama' => 'required|string|max:255',
        //     'harga' => 'required|numeric',
        //     'kategori' => 'required|exists:kategori,id_kategori',
        //     'produk' => 'required|array',
        //     'produk.*' => 'exists:produk,id_produk',
        // ]);

        // Create the menu and store it in the $menu variable
        if ($request->hasFile('image_menu')) {
            $image = $request->file('image_menu');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('menu', $imageName, 'public');
            $newpath = 'storage/menu/' . $imageName;
        }
        $menu = Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga_menu' => $request->harga_menu,
            'kategori_menu' => $request->kategori_menu,
            'image_menu' => $newpath
        ]);

        foreach ($request->input('produk') as $produkId) {
            Resep::create([
                'id_resep' => $menu->id_menu,
                'id_stok' => $produkId,
                // 'jumlah_stok' => $request->'stok_produk'[$produkId]
            ]);
        }

        // Retrieve all products and categories
        $produk = Produk::all();
        $kategori = Kategori::all();

        // Return the view with the retrieved data
        return view('adminMenu', compact('produk', 'kategori'));
    }


    public function deleteProduk($id){
        $produk = Produk::findOrFail($id);
        $produk->update(['status' => 0]); // Mengubah status menjadi 0
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus.');
    }


    public function indexKategori(){
        $kategori = Kategori::all();
        return view('kategori', compact('kategori'));
    }

    public function addKategori(Request $request)
    {
        Kategori::create($request->all());
        return redirect()->route('admin.kategori')->with('success', 'Data Produk berhasil ditambahkan.');
    }



    public function indexUsers(){
        $users = User::all();
        return view('adminusers', compact('users'));
    }
    public function bestPegawai() {
        $bestPegawai = Pegawai::orderBy('jumlah_confirm', 'desc')->get();
         return view('bestPegawai', ['pegawai' => $bestPegawai]);
    }
    public function bestSeller()
    {
        $bestSellers = Cart::select('id_menu', \DB::raw('SUM(jumlah) as total_jumlah'))
                            ->where('status', 2)
                            ->groupBy('id_menu')
                            ->orderBy('total_jumlah', 'desc')
                            ->get();

        $bestSellerData = $bestSellers->map(function($item) {
            $menu = Menu::find($item->id_menu);
            return [
                'nama_menu' => $menu->nama_menu,
                'harga_menu' => $menu->harga_menu,
                'jumlah_dipesan' => $item->total_jumlah,
                'total' => $item->total_jumlah * $menu->harga_menu,
            ];
        });

        return view('bestSeller', ['bestSellers' => $bestSellerData]);
    }
    public function indexCash()
    {
        $cashData = \DB::table('cash')->orderBy('tanggal', 'desc')->get();
        return view('adminCash', compact('cashData'));
    }
    public function addCash(Request $request)
    {
        $request->validate([
            'jumlah_cash' => 'required|numeric|min:0',
        ]);

        \DB::transaction(function () use ($request) {
            $jumlahCash = $request->input('jumlah_cash');


            $latestCash = \DB::table('cash')->latest('id_cash')->first();

            if (!$latestCash) {
                abort(404, 'Cash record not found.');
            }


            $newCashAmount = $latestCash->jumlah_cash + $jumlahCash;
            \DB::table('cash')->where('id_cash', $latestCash->id_cash)->update([
                'jumlah_cash' => $newCashAmount,
                'tanggal' => now(),
            ]);


            \DB::table('cash_in')->insert([
                'cash_in' => $jumlahCash,
                'tanggal' => now(),
            ]);
        });

        return redirect()->route('admin.cash')->with('success', 'Cash berhasil ditambahkan.');
    }
    public function indexCashIn()
    {
        $cashInData = \DB::table('cash_in')->get();
        return view('adminCashIn', compact('cashInData'));
    }

    public function indexCashOut()
    {
        $cashOutData = \DB::table('cash_out')
            ->join('produk', 'cash_out.id_produk', '=', 'produk.id_produk')
            ->select('cash_out.*', 'produk.nama_produk') 
            ->get();
    
        return view('adminCashOut', compact('cashOutData'));
    }

    public function updatekategori(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if ($kategori) {
            $updateData = $request->all();
            // logger()->info('Update Data: ', $updateData);
            $kategori->update($updateData);

            return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diupdate.');
        }

        return redirect()->route('admin.kategori')->with('error', 'Kategori tidak ditemukan.');
    }


    public function deletekategori($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus.');
    }


    public function gajiPegawai(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required',
            'jumlah_gaji' => 'required|numeric'
        ]);

        DB::table('cash_out')->insert([
            'cash_out' => $request->jumlah_gaji,
            'tanggal' => now()
        ]);

        $id_cashout = DB::getPdo()->lastInsertId();

        DB::table('cash')->update([
            'jumlah_cash' => DB::raw('jumlah_cash - ' . $request->jumlah_gaji)
        ]);

        TransaksiPegawai::create([
            'id_pegawai' => $request->id_pegawai,
            'id_cashout' => $id_cashout
        ]);

        return redirect()->route('admin.index')->with('success', 'Gaji Pegawai berhasil ditambahkan.');
    }
    public function viewReturn(){
        $dtrans = Dtrans::with('menu')->get();
        // dd($dtrans);
        return view('returnfood',compact('dtrans'));
    }
    public function viewAdd(Request $request){
        $returnfood =Returnfood::create([
            'id_nota' => $request->id,
            'id_menu' => $request->id_menu,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'alasan' => $request->alasan
        ]);
        DB::table('cash_out_order')->insert([
            'cash_out' => ($request->harga * $request->jumlah),
            'id_menu' => $request->id_menu,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'tanggal' => now()
        ]);
        DB::table('cash')->update([
            'jumlah_cash' => DB::raw('jumlah_cash - ' . ($request->harga * $request->jumlah))
        ]);
        $dtrans = Dtrans::with('menu')->get();
        // dd($dtrans);
        return view('returnfood',compact('dtrans'));

    }

}
