<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Session;

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
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
                    ->where('password', $request->password)
                    ->first();

        if ($user) {
            Session::put('user_id', $user->id_user);
            Session::put('username', $user->username);
            return redirect('/index');
        }

        // Cek apakah user berada di tabel pegawai
        $pegawai = Pegawai::where('nama_pegawai', $request->username)
                         ->where('password_pegawai', $request->password)
                         ->first();

        if ($pegawai) {
            Session::put('pegawai_id', $pegawai->id_pegawai);
            Session::put('pegawai_name', $pegawai->nama_pegawai);
            return redirect('/menu');
        } else {
            return redirect('/')->withErrors(['loginError' => 'Login failed']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
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
}
