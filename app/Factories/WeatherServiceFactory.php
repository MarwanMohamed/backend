<?php

namespace App\Factories;

use App\Services\OpenWeatherMapService;
use App\Services\MultipleSourcesService;

class WeatherServiceFactory
{
	/*
	 * @param str $weatherServiceName
	 *	return object from the name of class if exist
	*/

	public static function make($weatherServiceName) {
		switch($weatherServiceName) {
			case 'OpenWeatherMapService':
				return new OpenWeatherMapService();
			case 'MultipleSourcesService':
				return new MultipleSourcesService();
			default:
				throw new \Exception(trans('error.classNotFound'), 1);
		}
	}
}