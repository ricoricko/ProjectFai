<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('/login', function () {

    return redirect('/index');
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
