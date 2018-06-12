<?php

namespace App\Http\Controllers;

use DB;

class CitiesController extends Controller
{
   
    public function getCities()
    {
        return app('db')->select("SELECT * FROM cities");
    }

}




    