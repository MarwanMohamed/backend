<?php

namespace App\Repository;

use DB;
use App\City;

class CitiesRepository
{
    /**
	 * get all cities from database
	 * @return json
	*/
    public function getCities()
    {
    	return City::all();
    }

}




    