<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::get('/index', function () {
    return view('index');
});

Route::get('/menu', function () {
    return view('menu');
});

Route::get('/payment', function () {
    return view('payment');
});
Route::get('/admin', function () {
    return view('admin');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/admin', [ManagerController::class, 'index'])->name('admin.index');
Route::resource('admin', ManagerController::class); 

Route::get('/admin/create', [ManagerController::class, 'create'])->name('admin.create');
Route::post('/admin', [ManagerController::class, 'store'])->name('admin.store');
