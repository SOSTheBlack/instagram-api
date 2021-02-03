<?php

namespace Sostheblack\InstagramApi;

use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClient
 *
 * @package Sostheblack\InstagramApi
 */
class HttpClient
{
    /**
     * HTTP Client.
     *
     * @var Client
     */
    protected $http_client;

    /**
     * Endpoint e credÃªnciais
     *
     * @var array
     */
    protected $settings
        = [
            'headers'  => [],
            'base_uri' => '',
        ];

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->http_client = new GuzzleClient($this->settings);
    }

    /**
     * Name of the method used for search requests.
     *
     * @param $path
     *
     * @return mixed|ResponseInterface
     */
    public function get($path): Response
    {
        return $this->http_client->request(self::GET, $path);
    }

    /**
     * Name of the method used for creation requests.
     *
     * @param $path
     * @param $body
     *
     * @return mixed|ResponseInterface
     */
    public function post($path, $body): Response
    {
        return $this->http_client->request(self::POST, $path, [
            'json' => $body,
        ]);
    }

    /**
     * Name of the method used for change requests.
     *
     * @param $path
     * @param $body
     *
     * @return mixed|ResponseInterface
     */
    public function put($path, $body): Response
    {
        return $this->http_client->request(self::PUT, $path, [
            'json' => $body,
        ]);
    }

    /**
     * Name of the method used for delete requests.
     *
     * @param $path
     *
     * @return mixed|ResponseInterface
     */
    public function delete($path): Response
    {
        return $this->http_client->request(self::DELETE, $path);
    }

    /**
     * Define headers settings.
     *
     * @param  array  $values
     */
    public function setHeaders(array $values): void
    {
        $this->settings['headers'] = array_merge($this->settings['headers'], $values);
    }

    /**
     * Define base uri.
     *
     * @param  string  $base_uri
     *
     * @throws Exception
     */
    public function setBaseURI(string $base_uri): void
    {
        if (filter_var($base_uri, FILTER_VALIDATE_URL) === false) {
            throw new Exception('Base uri Inválido.');
        }

        $this->settings['base_uri'] = $base_uri;
    }

    /**
     * Returns settings defined for the header.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->settings['headers'];
    }

    /**
     * Returns settings defined for the base uri.
     *
     * @return string
     */
    public function getBaseURI(): string
    {
        return $this->settings['base_uri'];
    }

    /**
     * Define a new settings.
     *
     * @param $key
     * @param $value
     *
     * @throws Exception
     */
    public function setSettings($key, $value): void
    {
        if (in_array($key, ['headers', 'base_uri'])) {
            throw new Exception('Não é possível setar o header nem o base uri através dessa função.');
        }

        $this->settings[$key] = $value;
    }

    /**
     * Returns setting.
     *
     * @param $key
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getSettings($key = null)
    {
        if ($key === null) {
            return $this->settings;
        }

        if (in_array($key, ['headers', 'base_uri'])) {
            throw new Exception('Não é possível resgatar o header nem o base uri através dessa função.');
        }

        if (! isset($this->settings[$key])) {
            throw new Exception('Herder não exite.');
        }

        return $this->settings[$key];
    }

    /**
     * Return instance of Client.
     *
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->http_client;
    }
}
