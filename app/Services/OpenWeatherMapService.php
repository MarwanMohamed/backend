<?php

namespace App\Services;

class OpenWeatherMapService implements WeatherServiceInterface 
{

	/**
     * @var url
     */
	private $url;

	/**
     * @var units
     */
	private $units;
	
	/**
     * @var appId
     */
	private $appId;
	

    /**
     * get api config from .env file
     *
     * @return void
     */
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

	/**
     * call openWeatherMapApi
     * @param $string city name 
     * @param int $day 
     * @return array of data
     */
	public function getTemperature($city, $day) 
	{	
		//prepare url to the api
		$queryParameters = http_build_query([
			'q' => $city,
			'cnt' => $day,
			'units' => $this->units,
			'APPID' => $this->appId,
		]);

		$url = "{$this->url}?{$queryParameters}";
	
		//get contents from OpenWeatherMap api
		try {
			$contents = file_get_contents(urldecode($url));
		} catch (\Exception $e) {
			throw new \Exception(trans('error.missingData'), 1);
		}

		if ($contents) {
			$weather = json_decode($contents);

			$tempMax = [];
			$tempMin = [];
			$icon = [];

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