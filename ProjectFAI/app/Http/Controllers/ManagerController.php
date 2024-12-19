<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Pegawai;
use App\Models\Produk;
use App\Models\User;
use App\Models\Resep;
use Illuminate\Http\Request;

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
        Produk::create($request->all());
        return redirect()->route('admin.produk')->with('success', 'Data Produk berhasil ditambahkan.');
    }
    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
        ]);

        return redirect()->route('admin.produk')->with('success', 'Data Produk berhasil diupdate.');
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
            $path = $image->storeAs('public/storage/menu', $imageName);
        }
        $menu = Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga_menu' => $request->harga_menu,
            'kategori_menu' => $request->kategori_menu,
            'image_menu' => $path
        ]);
        foreach ($request->input('produk') as $produkId) {
            Resep::create([
                'id_menu' => $menu->id_menu,
                'id_produk' => $produkId
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
}
