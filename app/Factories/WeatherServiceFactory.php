<?php

namespace App\Factories;

use App\Services\OpenWeatherMapService;

class WeatherServiceFactory
{
	/*
	 * @param str $weatherServiceName
	 *	return object from the name of class if exist
	*/

	public static function make($weatherServiceName) {
		switch($weatherServiceName) {
			case 'OpenWeatherMap':
				return new OpenWeatherMapService();
			default:
				return null;
		}
	}
}