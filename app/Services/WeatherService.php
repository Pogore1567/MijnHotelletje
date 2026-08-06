<?php

namespace App\Services;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Http; 

class WeatherService
{
    /**
     * Create a new class instance.
     */
    public function weather(Request $request)
    {
        $apiKey = env('OPEN_WEATHER_API_KEY');

    if ($request->filled('city')) {

        $city = $request->input('city');
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";
    } else {

        $location = geoip()->getLocation();
        $lat = $location->lat;
        $lon = $location->lon;

        if (!$lat || !$lon) {

        $city = 'Amsterdam';
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=Amsterdam&appid={$apiKey}&units=metric";
    } else {
        $city = $location->city ?? 'Unknown';
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";
    
    }
    }

    $response = Http::get($apiUrl);

        return [
            'weather' => $response->successful() ? $response->json() : null,
            'city'    => $city,
        ];

    
   }

}
