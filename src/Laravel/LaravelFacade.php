<?php

namespace yedincisenol\Parasut\Laravel;

use Illuminate\Support\Facades\Facade;

class LaravelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Parasut::class;
    }
}
