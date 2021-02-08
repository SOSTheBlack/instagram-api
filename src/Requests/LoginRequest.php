<?php

namespace Sostheblack\InstagramApi\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Sostheblack\InstagramApi\InstagramApi;

/**
 * Class HomeRequest
 *
 * @package Sostheblack\InstagramApi\Requests
 */
class LoginRequest extends BaseRequest
{
    /**
     * API Endpoint.
     *
     * @const string
     */
    private const ENDPOINT = '/accounts/login/ajax/';

    private string $username;
    private string $password;

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
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws GuzzleException
     */
    public function execute()
    {
        $form = [
            "username"     => $this->username,
            "enc_password" => self::generateEncPassword($this->password),
        ];

        $response = $this->instagramApi->request(self::POST, self::ENDPOINT, ['form_params' => $form]);

        return $response;
    }

    /**
     * @param  string  $password
     *
     * @return string
     */
    private static function generateEncPassword(string $password): string
    {
        return '#PWD_INSTAGRAM_BROWSER:0:'.time().":".$password;
    }

    /**
     * @param  string  $username
     *
     * @return LoginRequest
     */
    public function setUsername(string $username): LoginRequest
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the username logged.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param  string  $password
     *
     * @return LoginRequest
     */
    public function setPassword(string $password): LoginRequest
    {
        $this->password = $password;

        return $this;
    }

}
