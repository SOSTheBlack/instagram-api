<?php

namespace Sostheblack\InstagramApi\Requests;

use Sostheblack\InstagramApi\InstagramApi;

/**
 * Class HomeRequest
 *
 * @package Sostheblack\InstagramApi\Requests
 */
class HomeRequest extends BaseRequest
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
    }

    public function execute()
    {
        config()->set('instagram-api.csrf-token', 'undefined');

        return $this->instagramApi->request(self::GET, self::ENDPOINT);
    }
}
