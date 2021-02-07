<?php

namespace Sostheblack\InstagramApi\Requests;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;
use Sostheblack\InstagramApi\InstagramApi;

/**
 * Class ProfileRequest
 *
 * @package Sostheblack\InstagramApi\Requests
 */
class ProfileRequest extends BaseRequest
{
    /**
     * API Endpoint.
     *
     * @const string
     */
    private const ENDPOINT = '/accounts/login/ajax/';

    private string $username;

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
     * @param  string|null  $username
     *
     * @throws GuzzleException
     */
    public function execute(?string $username = null)
    {
        $endpoint = vprintf(self::ENDPOINT, [$username ?? $this->instagramApi->login->getUsername()]);

        $responseProfile = $this->instagramApi->request(self::GET, $endpoint, [
            'query' => ['__a' => 1],
            'headers'     => $this->instagramApi->getHeaders(),
        ]);

        return (string) $responseProfile->getBody();
    }

    /**
     * @param  string  $username
     */
    public function setUsername(string $username): ProfileRequest
    {
        $this->username = $username;

        return $this;
    }
}