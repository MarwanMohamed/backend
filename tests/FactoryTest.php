<?php

use App\Factories\WeatherServiceFactory;

class FactoryTest extends TestCase
{	
    public function testFactory()
    {
        $creation = WeatherServiceFactory::make('OpenWeatherMap');
        
	    $this->assertInstanceOf('App\Services\OpenWeatherMapService', $creation);
    }
}