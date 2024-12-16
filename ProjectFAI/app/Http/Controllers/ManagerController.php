<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pegawai;
use App\Models\Produk;
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
}
