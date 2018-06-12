<?php

use App\Services\OpenWeatherMapService;

class ServiceTest extends TestCase
{	
    public function testFactory()
    {
        $service = new OpenWeatherMapService;
        $respon = $service->getTemperature(360630, 12-06-2018);

	    $this->assertArrayHasKey('max', $respon);
    }
}