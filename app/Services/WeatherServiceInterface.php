<?php

namespace App\Services;

interface WeatherServiceInterface
{
	public function getTemperature($city, $day);
}