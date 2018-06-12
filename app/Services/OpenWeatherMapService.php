<?php

namespace App\Services;

class OpenWeatherMapService implements WeatherServiceInterface 
{

	private $url;
	private $units;
	private $appId;
	
	public function __construct()
	{
		if (config('OpenWeatherMap.url') && config('OpenWeatherMap.appId')) {
			$this->url = config('OpenWeatherMap.url');
			$this->units = config('OpenWeatherMap.units');
			$this->appId = config('OpenWeatherMap.appId');
		} else {
			throw new \Exception("APPURL Or APPID Not Found, Please check .env file", 1);
		}
	}

	
	public function getTemperature($city, $day) 
	{
		$queryParameters = http_build_query([
			'id' => $city,
			'cnt' => $day,
			'units' => $this->units,
			'APPID' => $this->appId,
		]);

		$url = "{$this->url}?{$queryParameters}";

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
				$date[] = $list->dt_txt;
			}
			
			$cityname = $weather->city->name;

			return [
				'name' => $cityname,
				'max' => $tempMax,
				'min' => $tempMin,
				'icon' => $icon,
				'date' => $date
			];

		} else {
			throw new \Exception("Please Check your city or date", 1);
		}
	}
}