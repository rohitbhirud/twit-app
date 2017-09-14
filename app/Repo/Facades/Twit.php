<?php

namespace App\Repo\Facades;

use Illuminate\Support\Facades\Facade;

/**
* A Twit Facade
*/
class Twit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'twit';
    }
}
