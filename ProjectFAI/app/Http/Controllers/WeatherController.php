<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function showWeather()
    {
        $apiKey = 'c383ed859686611d1a779489aaa4aa27';
        $city = 'Kertajaya, Surabaya';
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

        $response = Http::get($url);
        $weatherData = $response->json();

        return view('index', ['weatherData' => $weatherData]);
    }
    public function index(){
        return view('index');
    }
}
?>
