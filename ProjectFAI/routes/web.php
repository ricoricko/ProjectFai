<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\AdminMiddleware;

// Halaman Login
Route::get('/', function () {
    return view('login');
})->name('login');

// Rute Otentikasi
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Profil Pengguna
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete', [AuthController::class, 'deleteAccount'])->name('profile.delete');

// Halaman Utama (Home)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Halaman Menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Rute Keranjang Tanpa Middleware sessionCheck
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Halaman Pembayaran
Route::get('/payment', function () {
    return view('payment');
})->name('payment');

// Panel Admin Tanpa Middleware sessionCheck
Route::get('/admin', [ManagerController::class, 'index'])->name('admin.index');

// Manajemen Produk
Route::get('/admin/produk', [ManagerController::class, 'indexproduk'])->name('admin.produk');
Route::post('/admin/produk/add', [ManagerController::class, 'addproduk'])->name('admin.addproduk');
Route::put('/admin/produk/update/{id}', [ManagerController::class, 'updateProduk'])->name('admin.updateproduk');
Route::delete('/admin/produk/delete/{id}', [ManagerController::class, 'deleteProduk'])->name('admin.deleteproduk');

// Manajemen Kategori
Route::get('/admin/kategori', [ManagerController::class, 'indexkategori'])->name('admin.kategori');
Route::post('/admin/kategori/add', [ManagerController::class, 'addkategori'])->name('admin.addkategori');
Route::put('/admin/kategori/update/{id}', [ManagerController::class, 'updateKategori'])->name('admin.updatekategori');
Route::delete('/admin/kategori/delete/{id}', [ManagerController::class, 'deleteKategori'])->name('admin.deletekategori');

// Debug Halaman Index
Route::get('/index', function () {
    return view('index');
})->name('index');
