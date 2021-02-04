<?php

namespace Sostheblack\InstagramApi\Requests;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Sostheblack\InstagramApi\Instagram;
use Sostheblack\InstagramApi\InstagramApi;
use Sostheblack\InstagramApi\Responses\LoginResponse;

/**
 * Class HomeRequest
 *
 * @package Sostheblack\InstagramApi\Requests
 */
class LoginRequest extends Request
{
    /**
     * API Endpoint.
     *
     * @const string
     */
    private const ENDPOINT = '/accounts/login/ajax/';

    /**
     * Request method.
     *
     * @const string
     */
    private const METHOD = 'POST';

    private string $username;
    private string $password;

    /**
     * @var InstagramApi
     */
    private InstagramApi $instagramApi;

    /**
     * @param InstagramApi $instagramApi
     */
    public function __construct(Instagram $instagramApi)
    {
        $this->instagramApi = $instagramApi;

        parent::__construct(self::METHOD, self::ENDPOINT);
    }

    /**
     * @return LoginResponse
     *
     * @throws GuzzleException
     */
    public function execute()
    {
        $form = [
            "username" => $this->username,
            "enc_password" => self::generateEncPassword($this->password)
        ];

        $responseLogin = $this->instagramApi->send($this, [
            'form' => $form,
            'headers' => $this->instagramApi->getDefaultHeaders()
        ]);

        $loginResource = (new LoginResponse($responseLogin));

        return $loginResource->toArray();
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private static function generateEncPassword(string $password): string
    {
        return '#PWD_INSTAGRAM_BROWSER:0:' . time() . ":" . $password;

    }

    /**
     * @param string $username
     *
     * @return LoginRequest
     */
    public function setUsername(string $username): LoginRequest
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return LoginRequest
     */
    public function setPassword(string $password): LoginRequest
    {
        $this->password = $password;

        return $this;
    }

}
