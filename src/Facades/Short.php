<?php

namespace Turtmcfly\Short\Facades;

use Illuminate\Support\Facades\Facade;

class Short extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'short';
    }
}