<?php

namespace Sostheblack\InstagramApi\Requests;

use GuzzleHttp\Psr7\Request;
use Sostheblack\InstagramApi\InstagramApi;
use Sostheblack\InstagramApi\Responses\HomeResponse;

/**
 * Class HomeRequest
 *
 * @package Sostheblack\InstagramApi\Requests
 */
class HomeRequest extends Request
{
    /**
     * API Endpoint.
     *
     * @const string
     */
    private const ENDPOINT = '/';
    /**
     * @var InstagramApi
     */
    private InstagramApi $instagramApi;

    /**
     * @param  InstagramApi  $instagramApi
     */
    public function __construct(InstagramApi $instagramApi)
    {
        $this->instagramApi = $instagramApi;

        parent::__construct('GET', self::ENDPOINT);
    }

    public function execute()
    {
        return new HomeResponse($this->instagramApi->sendRequest($this));
    }

}
