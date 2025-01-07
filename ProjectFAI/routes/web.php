<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\AdminMiddleware;

// Login page
Route::get('/', function () {
    return view('login');
})->name('login');

// Auth Routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// User Profile Routes
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete', [AuthController::class, 'deleteAccount'])->name('profile.delete');

// Home page
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

});

// Payment page
Route::get('/payment', function () {
    return view('payment');
})->name('payment');



Route::middleware([AdminMiddleware::class])->group(function () {
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
    Route::get('/admin/menu', [ManagerController::class, 'indexMenu'])->name('admin.menu');
    Route::post('/admin-addMenu', [ManagerController::class, 'addMenu'])->name('admin.addMenu');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin', [ManagerController::class, 'index'])->name('admin.index');
    Route::resource('admin', ManagerController::class);
});


Route::get('/admin/create', [ManagerController::class, 'create'])->name('admin.create');
Route::post('/admin', [ManagerController::class, 'store'])->name('admin.store');
Route::resource('admin', ManagerController::class)->except(['index', 'create', 'store']);

// Debug Index Page
Route::get('/index', function () {
    return view('index');
});
