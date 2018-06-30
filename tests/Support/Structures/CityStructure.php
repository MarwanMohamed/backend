<?php

namespace Tests\Support\Structures;

trait CityStructure
{
    public function cityStructure($additional = [])
    {
        return array_merge(['id', 'name'], $additional);
    }
}
