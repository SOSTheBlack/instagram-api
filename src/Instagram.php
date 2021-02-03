<?php

namespace Sostheblack\InstagramApi;

use Sostheblack\InstagramApi\Exceptions\CookieException;
use Sostheblack\InstagramApi\Traits\CsrfToken;

/**
 * Class Instagram
 *
 * @package Sostheblack\InstagramApi
 */
class Instagram extends InstagramApi
{
    use CsrfToken;

    /**
     * @var string
     */
    protected string $csrfToken;

    /**
     * Instagram constructor.
     *
     * @throws CookieException
     */
    public function __construct()
    {
        parent::__construct();

        $this->defineCsrfToken();
    }
}
