<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\Support\Structures\CityStructure;

class CityTest extends TestCase
{
    use CityStructure;

    public function test_city_in_database()
    {
        $this->seeInDatabase('cities', ['name' => 'Alexandria']);
    }

    public function test_city_json_structure()
    {
	 	$this->json('get', 'api/cities')->seeJsonStructure(['*' => $this->cityStructure()]);
    }
}
