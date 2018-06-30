<?php

namespace App\Services;

interface WeatherServiceInterface
{	
	/**
	 * call api and get temperature
  	 * @param string @city  
     * @param int $day 
     * @return array
     */
	public function getTemperature($city, $day);
}