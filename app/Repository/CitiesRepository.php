<?php

namespace App\Repository;

use DB;
use App\City;

class CitiesRepository
{
    /**
	 * @return all cities from database
	*/
    public function getCities()
    {
    	return City::all();
    }

}




    