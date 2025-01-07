<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:2',
            'phone' => 'required|string',
            'name' => 'required|string',
        ]);

        $username = $request->input('username');

        // Pengecekan apakah username ada di tabel pegawai
        $pegawaiExists = Pegawai::where('nama_pegawai', $username)->exists();
        if ($pegawaiExists) {
            return redirect('/')->with('error', 'Username already exists in pegawai!');
        }

        // Simpan data
        User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'nama' => $request->input('name'),
            
        ]);

        return redirect('/')->with('success', 'Account created successfully! Please login.');
    }


    public function login(Request $request)
{
    $validated = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Cari user berdasarkan username dan password
    $user = DB::table('users')
              ->where('username', $validated['username'])
              ->where('password', $validated['password']) // Gunakan hashing jika memungkinkan
              ->first();

    if ($user) {
        // Simpan id_user ke session
        Session::put('id_user', $user->id_user);
        Session::put('username', $user->username);

        // Redirect ke halaman index
        return redirect()->route('index')->with('success', 'Login berhasil!');
    }

    return redirect()->back()->with('error', 'Login gagal! Periksa username dan password Anda.');
}


    public function logout()
    {
        Session::flush(); // Hapus semua data session
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }


    public function profile()
    {
        $user = User::find(Session::get('user_id'));
        return view('ProfileUser', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Session::get('user_id'));
        
        $request->validate([
            'nama' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $user->nama = $request->input('nama');
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->img = $filename;
        }
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
    public function deleteAccount()
    {
        $user = User::find(Session::get('user_id'));
        $user->status = '0'; 
        $user->save();

        Session::flush();

        return redirect('/')->with('success', 'Your account has been deactivated.');
    }
}
