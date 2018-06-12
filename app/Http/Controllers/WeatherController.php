<?php

namespace App\Http\Controllers;

use App\Factories\WeatherServiceFactory;
use Carbon\Carbon;

class WeatherController extends Controller
{
   
    public function getWeatherTemperature($city, $day)
	{
		if (! $city || ! $day) {
			throw new \Exception("City and Day inputs is Required.", 1);
		}
		$today = date("m.d.y");
		$day = Carbon::parse($day);
		$numberOfDays = ($day->diffInDays(Carbon::now()->subHours(23)));
		$temperatureService = WeatherServiceFactory::make('OpenWeatherMap');
		$temperature = $temperatureService->getTemperature($city, $numberOfDays);

		return response()->json($temperature, 200);
	}
}