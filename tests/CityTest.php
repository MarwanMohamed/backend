<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CityTest extends TestCase
{
    
    public function testCityInDatabase()
    {
        $this->seeInDatabase('cities', ['name' => 'Alexandria']);
    }
}
