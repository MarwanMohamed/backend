<?php

namespace App\Http\Controllers;

use App\Factories\WeatherServiceFactory;
use Carbon\Carbon;

class WeatherController extends Controller
{
   /**
	 * return temperature of city
	 * @param str $city
	 * @param str $day
	 * @return json
	*/
    public function getWeatherTemperature($city, $day)
	{	
		// validate if any param missing
		if (! $city || ! $day) {
			throw new \Exception(trans('error.getWeatherparms'), 1);
		}
		//change date to number to call api with the number
		$today = date("m.d.y");
		$day = Carbon::parse($day);
		$numberOfDays = ($day->diffInDays(Carbon::now()->subHours(23)));
		//call the api to get temperature
		$temperatureService = WeatherServiceFactory::make('OpenWeatherMapService');
		$temperature = $temperatureService->getTemperature($city, $numberOfDays);
		return response()->json($temperature, 200);
	}
}