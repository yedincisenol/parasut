<?php

namespace yedincisenol\Parasut\Laravel;

use yedincisenol\Parasut\Parasut;
use Illuminate\Support\Facades\Facade;

class LaravelFacede extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Parasut::class;
    }
}
