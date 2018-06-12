<?php

use App\Http\Controllers\WeatherController;

class WeatherTest extends TestCase
{	
    public function testWeather()
    {
        $weather = New WeatherController;
        $respon = $weather->getWeatherTemperature(360630, 21-06-2018);
        
	    $this->assertInstanceOf('Illuminate\Http\JsonResponse', $respon);
    }
}