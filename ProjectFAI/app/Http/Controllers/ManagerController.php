<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('admin', compact('pegawai'));
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
}
