<?php

namespace Sostheblack\InstagramApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sostheblack\InstagramApi\InstagramApi
 */
class InstagramApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'instagram-api';
    }
}
