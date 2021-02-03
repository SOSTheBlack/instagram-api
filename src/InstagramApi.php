<?php

namespace Sostheblack\InstagramApi;

use GuzzleHttp\Client as HttpClient;
use Sostheblack\InstagramApi\Requests\HomeRequest;

/**
 * Class InstagramApi
 *
 * @package Sostheblack\InstagramApi
 */
class InstagramApi extends HttpClient implements InstagramApiContracts
{
    /**
     * Base URI.
     *
     * @const string
     */
    private const BASE_URI = 'https://www.instagram.com';

    /**
     * InstagramApi constructor.
     */
    public function __construct()
    {
        parent::__construct(['base_uri' => self::BASE_URI]);
    }

    public function home()
    {
        return app(HomeRequest::class, [$this]);
    }
}
