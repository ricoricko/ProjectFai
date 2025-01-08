<!DOCTYPE html>
<html>
<head>
    <title>Weather in Kertajaya, Surabaya</title>
</head>
<body>
    <h1>Weather in Kertajaya, Surabaya</h1>
    @if(isset($weatherData))
        <p>Temperature: {{ $weatherData['main']['temp'] }}°C</p>
        <p>Weather: {{ $weatherData['weather'][0]['description'] }}</p>
        <p>Humidity: {{ $weatherData['main']['humidity'] }}%</p>
        <p>Wind Speed: {{ $weatherData['wind']['speed'] }} m/s</p>
        <p><img src="http://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}@2x.png" alt="Weather icon"></p>

        @if(str_contains($weatherData['weather'][0]['description'], 'rain') || 
           str_contains($weatherData['weather'][0]['description'], 'shower rain') || 
           str_contains($weatherData['weather'][0]['description'], 'thunderstorm') ||
           str_contains($weatherData['weather'][0]['description'], 'light rain') ||
           str_contains($weatherData['weather'][0]['description'], 'moderate rain') ||
           str_contains($weatherData['weather'][0]['description'], 'heavy rain'))
            <p>Bring umbrella!</p>
        @elseif(str_contains($weatherData['weather'][0]['description'], 'scattered clouds') ||
               str_contains($weatherData['weather'][0]['description'], 'broken clouds') ||
               str_contains($weatherData['weather'][0]['description'], 'overcast clouds'))
            <p>Prepare umbrella!</p>
        @elseif(str_contains($weatherData['weather'][0]['description'], 'clear sky') || 
               str_contains($weatherData['weather'][0]['description'], 'few clouds'))
            <p>What a lovely day!</p>
        @endif
        
    @else
        <p>Unable to retrieve weather data.</p>
    @endif
</body>
</html>
