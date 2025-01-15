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

    $pegawaiExists = Pegawai::where('nama_pegawai', $username)->exists();
    if ($pegawaiExists) {
        return redirect('/')->with('error', 'Username already exists in pegawai!');
    }

    User::create([
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'phone' => $request->input('phone'),
        'nama' => $request->input('name'),
        'status' => 1, 
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
                    ->where('status', '1')
                    ->first();
    
        if ($user) {
            Session::put('id_user', $user->id_user); 
            Session::put('username', $user->username);
            return redirect('/index');
        }
    
        $pegawai = Pegawai::where('nama_pegawai', $request->username)
                          ->where('password_pegawai', $request->password)
                          ->first();
        
        if ($pegawai) {
            Session::put('pegawai_id', $pegawai->id_pegawai);
            Session::put('pegawai_name', $pegawai->nama_pegawai);
    
            if ($pegawai->status_pegawai == '1') {
                return redirect('/admin'); 
            } else {
                return redirect('/pegawai');
            }
        }
    
        return redirect('/')->withErrors(['loginError' => 'Login failed']);
    }
    

    
    

    public function logout()
{
    Session::flush(); 
    return redirect('/');
}

public function profile()
{
    $user = User::find(Session::get('id_user')); 

    if (!$user) {
        return redirect('/')->with('error', 'Session expired. Please login again.');
    }

    return view('ProfileUser', compact('user'));
}



public function updateProfile(Request $request)
{
    $user = User::find(Session::get('id_user'));

    if (!$user) {
        return redirect()->back()->with('error', 'User not found. Please login again.');
    }

    $request->validate([
        'nama' => 'required|string|max:255',
        'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000',
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
    $user = User::find(Session::get('id_user'));

    if (!$user) {
        return redirect()->back()->with('error', 'User not found. Please login again.');
    }

    $user->status = '0';
    $user->save();

    Session::flush();

    return redirect('/')->with('success', 'Your account has been deactivated.');
}

}