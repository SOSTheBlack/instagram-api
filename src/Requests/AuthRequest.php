<?php

namespace Sostheblack\InstagramApi\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Sostheblack\InstagramApi\Exceptions\AuthException;
use Sostheblack\InstagramApi\InstagramApi;

/**
 * Class HomeRequest
 *
 * @package Sostheblack\InstagramApi\Requests
 */
class AuthRequest extends BaseRequest
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

    public function actingAs(string $username): \stdClass
    {
        try {
            $user = Storage::disk($this->instagramApi::STORAGE_DISK)->get(vsprintf('%s.json', [$username]));
            $this->instagramApi->login->setUsername($username);

            return json_decode($user);
        } catch (FileNotFoundException $fileNotFoundException) {
            throw new AuthException(message: 'Login required', previous: $fileNotFoundException);
        }
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws GuzzleException
     */
    public function login()
    {
        $form = [
            "username"     => $this->username,
            "enc_password" => self::generateEncPassword($this->password),
        ];

        $loginResponse = $this->instagramApi->request(self::POST, self::ENDPOINT, ['form_params' => $form]);

        $bodyResponse = json_decode($loginResponse->getBody()->getContents(), true);
        $bodyResponse['username'] = $this->username;
        $bodySession = array_merge($bodyResponse, ['headers' => $loginResponse->getHeaders()]);

        Storage::disk('instagram-api')->put(vsprintf('%s.json', [$this->username]), json_encode($bodySession));

        return $bodyResponse;
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
     * @return AuthRequest
     */
    public function setUsername(string $username): AuthRequest
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
     * @return AuthRequest
     */
    public function setPassword(string $password): AuthRequest
    {
        $this->password = $password;

        return $this;
    }

}
