<?php

namespace App\Http\Controllers;

use DB;
use App\City;
use App\Repository\CitiesRepository;

class CitiesController extends Controller
{
	/**
     * The CitiesRepository instance.
     *
     * @var CitiesRepository
     */
    private $citiesRepository;

    /**
     * Create a new CitiesRepository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->citiesRepository = new CitiesRepository();
    }

    /**
	 *	get all cities from repository class
	*/
    public function getCities()
    {
    	return $this->citiesRepository->getCities();
    }
}




    