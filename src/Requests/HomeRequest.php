<?php

namespace Sostheblack\InstagramApi\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\Response;
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

    /**
     * @return Response
     *
     * @throws GuzzleException
     */
    public function execute(): Response
    {
        config()->set('instagram-api.csrf-token', 'undefined');

        return $this->instagramApi->request(self::GET, self::ENDPOINT);
    }
}
