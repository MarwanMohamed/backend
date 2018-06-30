<?php

namespace Tests\Support\Structures;

trait WeatherStructure
{
    public function weatherStructure($additional = [])
    {
        return array_merge(['max', 'min', 'icon', 'name'], $additional);
    }
}
