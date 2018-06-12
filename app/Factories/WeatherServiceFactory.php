<?php

namespace App\Factories;

use App\Services\OpenWeatherMapService;

class WeatherServiceFactory
{
	public static function make($weatherServiceName) {
		switch($weatherServiceName) {
			case 'OpenWeatherMap':
				return new OpenWeatherMapService();
			default:
				return null;
		}
	}
}