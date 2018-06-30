<?php

use App\Factories\WeatherServiceFactory;

class FactoryTest extends TestCase
{	
    public function testFactory()
    {
        $creation = WeatherServiceFactory::make('OpenWeatherMapService');
	    $this->assertInstanceOf('App\Services\OpenWeatherMapService', $creation);
    }
}