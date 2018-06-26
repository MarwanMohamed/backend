<?php

namespace App\Services;

class OpenWeatherMapService implements WeatherServiceInterface 
{

	private $url;
	private $units;
	private $appId;
	
	public function __construct()
	{	
		// get config from .env file
		if (config('OpenWeatherMap.url') && config('OpenWeatherMap.appId')) {
			$this->url = config('OpenWeatherMap.url');
			$this->units = config('OpenWeatherMap.units');
			$this->appId = config('OpenWeatherMap.appId');
		} else {
			throw new \Exception(trans('error.apiConfig'), 1);
		}
	}

	
	public function getTemperature($city, $day) 
	{	
		//prepare url to the api
		$queryParameters = http_build_query([
			'id' => $city,
			'cnt' => $day,
			'units' => $this->units,
			'APPID' => $this->appId,
		]);

		$url = "{$this->url}?{$queryParameters}";
		//get contents from OpenWeatherMap api
		$contents = @file_get_contents($url);

		if ($contents) {
			$weather = json_decode($contents);

			$tempMax = [];
			$tempMin = [];
			$icon = [];
			$dates = [];

			foreach ($weather->list as $list) {
				$tempMax[] = $list->main->temp_max;
				$tempMin[] = $list->main->temp_min;
				$icon[] = $list->weather[0]->icon.".png";
			}
			
			$cityname = $weather->city->name;

			return [
				'name' => $cityname,
				'max' => $tempMax,
				'min' => $tempMin,
				'icon' => $icon,
			];

		} else {
			throw new \Exception(trans('error.missingData'), 1);
		}
	}
}