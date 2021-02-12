<?php

namespace Sostheblack\InstagramApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\Factory as Http;
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
class InstagramApi extends Http implements InstagramApiContracts
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
        $this->withOptions(['base_uri' => self::BASE_URI]);
//        parent::__construct(['base_uri' => self::BASE_URI]);

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
    public function request(string $method, $uri = '', array $options = []): \Illuminate\Http\Client\Response
    {
        $options['headers'] = isset($options['headers']) ? $this->structureHeaders($options['headers']) : $this->structureHeaders([]);

        $this->withHeaders($options['headers']);

        unset($options['headers']);

        /** @var \Illuminate\Http\Client\Response $response */
        $response = $this->$method(self::BASE_URI.$uri, $options);

        $this->headers = array_merge($this->headers, $response->headers());

        return $response;
    }

    public function auth(): AuthRequest
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
