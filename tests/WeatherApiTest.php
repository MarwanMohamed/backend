<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\Support\Structures\WeatherStructure;

class WeatherApiTest extends TestCase
{
    use WeatherStructure;


    public function test_weather()
    {
        $respon = $this->json('get', 'api/getTemprature/360630, 30-06-2018');
        dd(get_class($respon));
	    $this->assertInstanceOf('Illuminate\Http\JsonResponse', $respon);
    }


   //  public function test_weather_structure()
   //  {
	 	// $this->json('get', 'api/getTemprature/360630, 30-06-2018')->seeJsonStructure(['*' => $this->weatherStructure()]);
   //  }
}
