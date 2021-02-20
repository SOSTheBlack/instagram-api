<?php

namespace Sostheblack\InstagramApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\Factory as Http;
use Illuminate\Http\Client\Response;
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
        parent::__construct();
    }

    /**
     * Create and send an HTTP request.
     *
     * @param string $method HTTP method.
     * @param string|UriInterface $uri URI object or string.
     * @param array $data Request options to apply. See \GuzzleHttp\RequestOptions.
     *
     * @throws GuzzleException
     */
    public function request(string $method, $uri = '', array $data = []): Response
    {
        /** @var Response $response */
        $response = $this
            ->baseUrl(self::BASE_URI)
            ->withHeaders($this->structureHeaders())
            ->asForm()
            ->$method($uri, $data);

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
