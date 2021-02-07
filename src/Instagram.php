<?php

namespace Sostheblack\InstagramApi;

use Sostheblack\InstagramApi\Exceptions\CookieException;
use Sostheblack\InstagramApi\Requests\LoginRequest;
use Sostheblack\InstagramApi\Traits\Headers;

/**
 * Class Instagram
 *
 * @package Sostheblack\InstagramApi
 */
class Instagram extends InstagramApi implements InstagramApiContracts
{
    /**
     * Instagram constructor.
     *
     * @throws CookieException
     */
    public function __construct()
    {
        parent::__construct();
    }


}
