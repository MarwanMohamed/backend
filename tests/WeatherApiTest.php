<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\Support\Structures\WeatherStructure;

class WeatherApiTest extends TestCase
{
    use WeatherStructure;

    public function test_weather()
    {
        $respon = $this->json('get', 'api/getTemprature/cairo/13-06-2018');
	    $this->assertInstanceOf('Illuminate\Http\JsonResponse', $respon);
    }

    public function test_weather_json_structure()
    {
	 	$this->json('get', 'api/getTemprature/cairo/13-06-2018')->seeJsonStructure(['*' => $this->weatherStructure()]);
    }
}
