<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('login');
});
Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
});

Route::get('/payment', [CartController::class, 'payment'])->name('payment');

Route::get('/index', function () {
    return view('index');
});
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/payment', function () {
    return view('payment');
})->name('payment');

Route::get('/admin', function () {
    return view('admin');
});
Route::get('/admin/produk', [ManagerController::class, 'indexproduk'])->name('admin.produk');
Route::post('/admin/produk/add', [ManagerController::class, 'addproduk'])->name('admin.addproduk');
Route::put('/admin/produk/update/{id}', [ManagerController::class, 'updateProduk'])->name('admin.updateproduk');
Route::delete('/admin/produk/delete/{id}', [ManagerController::class, 'deleteProduk'])->name('admin.deleteproduk');



Route::get('/admin/kategori', [ManagerController::class, 'indexkategori'])->name('admin.kategori');
Route::post('/admin/kategori/add', [ManagerController::class, 'addkategori'])->name('admin.addkategori');
Route::put('/admin/kategori/update/{id}', [ManagerController::class, 'updateKategori'])->name('admin.updatekategori');
Route::delete('/admin/kategori/delete/{id}', [ManagerController::class, 'deleteKategori'])->name('admin.deletekategori');

Route::get('/admin/users', [ManagerController::class, 'indexUsers'])->name('admin.users');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/admin', [ManagerController::class, 'index'])->name('admin.index');
Route::resource('admin', ManagerController::class); 

Route::get('/admin/create', [ManagerController::class, 'create'])->name('admin.create');
Route::post('/admin', [ManagerController::class, 'store'])->name('admin.store');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete', [AuthController::class, 'deleteAccount'])->name('profile.delete');
