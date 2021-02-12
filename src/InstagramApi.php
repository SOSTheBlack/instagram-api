<?php

namespace Sostheblack\InstagramApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Sostheblack\InstagramApi\Requests\HomeRequest;
use Sostheblack\InstagramApi\Requests\AuthRequest;
use Sostheblack\InstagramApi\Requests\ProfileRequest;
use Sostheblack\InstagramApi\Traits\Headers;
use Sostheblack\InstagramApi\Traits\Requests;

/**
 * Class InstagramApi
 *
 * @package Sostheblack\InstagramApi
 */
class InstagramApi extends HttpClient implements InstagramApiContracts
{
    use Headers, Requests;

    /**
     * Base URI.
     *
     * @const string
     */
    private const BASE_URI = 'https://www.instagram.com';
    public AuthRequest $login;
    public ProfileRequest $profile;

    /**
     * InstagramApi constructor.
     */
    public function __construct()
    {
        parent::__construct(['base_uri' => self::BASE_URI]);

//        $this->login();
//        $this->profile();
    }

    /**
     * Create and send an HTTP request.
     *
     * @param string $method HTTP method.
     * @param string|UriInterface $uri URI object or string.
     * @param array $options Request options to apply. See \GuzzleHttp\RequestOptions.
     *
     * @throws GuzzleException
     */
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        $options['headers'] = isset($options['headers']) ? $this->structureHeaders($options['headers']) : $this->structureHeaders([]);

        $response = parent::request($method, $uri, $options);

        $this->headers = array_merge($this->headers, $response->getHeaders());

        return $response;
    }

    public function login(): AuthRequest
    {
        return $this->login = new AuthRequest($this);
    }

    public function profile(): ProfileRequest
    {
        return $this->profile = new ProfileRequest($this);
    }

    protected function home(): HomeRequest
    {
        return $this->home = new HomeRequest(clone $this);
    }
}
