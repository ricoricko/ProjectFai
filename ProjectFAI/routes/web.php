<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\PegawaiMiddleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete', [AuthController::class, 'deleteAccount'])->name('profile.delete');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

// Halaman Pembayaran
Route::get('/payment', function () {
    return view('payment');
})->name('payment');

// Panel Admin Tanpa Middleware sessionCheck
// Route::get('/admin', [ManagerController::class, 'index'])->name('admin.index');


Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin', [ManagerController::class, 'index']);
    Route::post('/admin/update', [ManagerController::class, 'update'])->name('admin.update');
    Route::delete('/admin/delete', [ManagerController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/store', [ManagerController::class, 'store'])->name('admin.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    
    Route::get('/admin/produk', [ManagerController::class, 'indexproduk'])->name('admin.produk');
    Route::post('/admin/produk/add', [ManagerController::class, 'addproduk'])->name('admin.addproduk');
    Route::put('/admin/produk/update/{id}', [ManagerController::class, 'updateProduk'])->name('admin.updateproduk');
    Route::delete('/admin/produk/delete/{id}', [ManagerController::class, 'deleteProduk'])->name('admin.deleteproduk');

    Route::get('/admin/kategori', [ManagerController::class, 'indexkategori'])->name('admin.kategori');
    Route::post('/admin/kategori/add', [ManagerController::class, 'addkategori'])->name('admin.addkategori');
    Route::put('/admin/kategori/update/{id}', [ManagerController::class, 'updateKategori'])->name('admin.updatekategori');
    Route::delete('/admin/kategori/delete/{id}', [ManagerController::class, 'deleteKategori'])->name('admin.deletekategori');
});

Route::middleware([PegawaiMiddleware::class])->group(function () {
    Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai/confirm', [App\Http\Controllers\PegawaiController::class, 'confirm'])->name('pegawai.confirm');
    

});

Route::middleware([PegawaiMiddleware::class])->group(function () {
    Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai/confirm', [App\Http\Controllers\PegawaiController::class, 'confirm'])->name('pegawai.confirm');
    

});







Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/map', function () {
    return view('map');
});
Route::get('/weather', [WeatherController::class, 'showWeather']);