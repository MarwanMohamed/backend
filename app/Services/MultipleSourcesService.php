<?php

namespace App\Services;

class MultipleSourcesService implements WeatherServiceInterface 
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
     * call apis and get the average temperature 
     * @param string @city  
     * @param int $day 
     * @return array
     */
	public function getTemperature($city, $day) 
	{
		$cityId = $this->getIdOfCityName($city);

		//prepare url to the api
		$queryParameters = http_build_query([
			'q' => $city,
			'cnt' => $day,
			'units' => $this->units,
			'APPID' => $this->appId,
		]);

		$openWeatherApiUrl = "{$this->url}?{$queryParameters}";
		$accuWeatherApiUrl =  config('AccuWeatherMap.apiUrl'). $cityId. "?apikey=" .config('AccuWeatherMap.apiId');
		
		$apisRespons = $this->callApis($openWeatherApiUrl, $accuWeatherApiUrl);
		return $this->getDataOfApis($apisRespons);
	}

	/**
	* get min and max from apis
	* @param json $apisRespons
	* @return array
	*/
	private function getDataOfApis($apisRespons)
	{
		$openWeatherApiContents = json_decode($apisRespons['openWeatherApi']->getBody()->getContents());
		$accuWeatherApiContents = json_decode($apisRespons['accuWeatherApi']->getBody()->getContents());
		$openWeatherData = [];
		$accWeatherData = [];

		// git max and min tempreature of open weather api
		foreach ($openWeatherApiContents->list as $list) {
			$openWeatherData['tempMax'][] = $list->main->temp_max;
			$openWeatherData['tempMin'][] =  $list->main->temp_min;
			$openWeatherData['icon'][] = $list->weather[0]->icon.".png";
		}

		// git max and min tempreature of acc weather api
		foreach($accuWeatherApiContents->DailyForecasts as $forcast) {
			$accWeatherData['tempMax'][] = $forcast->Temperature->Maximum->Value;
			$accWeatherData['tempMin'][] =  $forcast->Temperature->Minimum->Value;
		}

		$cityname = $openWeatherApiContents->city->name;

		$data = $this->getAverage($openWeatherData, $accWeatherData);
		$data['icon'] = $openWeatherData['icon'];
		$data['name'] = $cityname;
		return $data;
	}

	/**
     * return average of two apis
     * @param array $openWeatherData
     * @param array $accWeatherData
     * @return array
     */
	private function getAverage($openWeatherData, $accWeatherData)
	{
		$maxTemperatue = array_map(function (...$arrays) {
		    return (array_sum($arrays) / 2);
		}, $openWeatherData['tempMax'], $accWeatherData['tempMax']);

		$minTemperatue = array_map(function (...$arrays) {
		    return (array_sum($arrays) / 2);
		}, $openWeatherData['tempMin'], $accWeatherData['tempMin']);

		return [
			'max' => $maxTemperatue,
			'min' => $minTemperatue,
		];
	}

	/**
     * Async openWeatherApi, accuWeatherApi
     * @param string $openWeatherApiUrl
     * @param string $accuWeatherApiUrl
     * @return array
     */
	private function callApis($openWeatherApiUrl, $accuWeatherApiUrl)
	{
		$client = new \GuzzleHttp\Client();
 	
 		//call open weather api url 
		$openWeatherApi = $client->getAsync(urldecode($openWeatherApiUrl));

 		//call accu weather api url 
		$accuWeatherApi = $client->getAsync($accuWeatherApiUrl);
		 
		$openWeatherApiResponse = $openWeatherApi->wait();
		$accuWeatherApiResponse = $accuWeatherApi->wait();
		 
		$data = [];
		$data['openWeatherApi'] = $openWeatherApiResponse;
		$data['accuWeatherApi'] = $accuWeatherApiResponse;
		return $data;
	}

	/**
     * call api to get id instead of name
     * @param int
     * @return array of data
     */
	private function getIdOfCityName($city)
	{
		$url = config('AccuWeatherMap.cityApiURL') .$city;
		try {
			$city = json_decode(file_get_contents($url));
			return $city[0]->Key;
		} catch (\Exception $e) {
			throw new \Exception(trans('error.accweatherUrlError'), 1);
		}
	}
}