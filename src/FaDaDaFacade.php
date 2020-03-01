<?php

namespace Zhuobin\FaDaDa\Src;

use Illuminate\Support\Facades\Facade;

class FaDaDaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FaDaDa';
    }
}
