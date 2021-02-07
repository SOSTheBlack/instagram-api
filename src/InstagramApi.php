<?php

namespace Sostheblack\InstagramApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Sostheblack\InstagramApi\Requests\HomeRequest;
use Sostheblack\InstagramApi\Requests\LoginRequest;
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

    public LoginRequest $login;
    public ProfileRequest $profile;


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

    /**
     * Create and send an HTTP request.
     *
     * @param  string  $method  HTTP method.
     * @param  string|UriInterface  $uri  URI object or string.
     * @param  array  $options  Request options to apply. See \GuzzleHttp\RequestOptions.
     *
     * @throws GuzzleException
     */
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        $options['headers'] = isset($options['headers']) ? $this->structureHeaders($options['headers']) : $this->structureHeaders([]);

        dump($uri);
        $response =  parent::request($method, $uri, $options);

        $this->headers = array_merge($this->headers, $response->getHeaders());

        return $response;
    }

    protected function home(): HomeRequest
    {
        return $this->home = new HomeRequest(clone $this);
    }

    public function login(): LoginRequest
    {
        return $this->login = new LoginRequest(clone $this);
    }

    public function profile(): ProfileRequest
    {
        return $this->profile = new ProfileRequest(clone $this);
    }
}
