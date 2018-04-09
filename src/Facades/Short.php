<?php

namespace Ignittion\Short;

use Illuminate\Support\Facades\Facade;

class ShortFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'short';
    }
}