<?php

namespace App\Http\Controllers;

use DB;
use App\City;

class CitiesController extends Controller
{
    /*
	 *	return all cities from database
	*/

    public function getCities()
    {
    	return City::all();
    }

}




    