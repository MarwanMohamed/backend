<?php

use App\Http\Controllers\WeatherController;

class WeatherTest extends TestCase
{	
    public function test_weather()
    {
        $weather = New WeatherController;
        $respon = $weather->getWeatherTemperature('cairo', 12-06-2018);
	    $this->assertInstanceOf('Illuminate\Http\JsonResponse', $respon);
    }
}