<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/index', function () {
    return view('index');
});

Route::get('/menu', function () {
    return view('menu');
});

Route::get('/payment', function () {
    return view('payment');
});
