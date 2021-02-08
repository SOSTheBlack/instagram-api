<?php

namespace Sostheblack\InstagramApi\Traits;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Sostheblack\InstagramApi\Exceptions\CookieException;


/**
 * Trait CsrfToken
 *
 * @package Sostheblack\InstagramApi\Traits
 */
trait Headers
{
    /**
     * @var string
     */
    protected string $csrfToken;
    /**
     * @var array
     */
    protected array $headers = [
        "accept-encoding" => 'gzip, deflate, br',
        "accept-language" => 'en-US,en;q=0.9',
        "content-type" => 'application/x-www-form-urlencoded',
        "origin" => 'https://www.instagram.com',
        "referer" => 'https://www.instagram.com/',
        "sec-fetch-dest" => 'empty',
        "sec-fetch-mode" => 'cors',
        "sec-fetch-site" => 'same-origin',
        "user-agent" => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36',
        "x-ig-app-id" => "936619743392459",
        "x-ig-www-claim" => "0",
        "x-instagram-ajax" => "ccf009398be5",
        "x-requested-with" => "XMLHttpRequest",
    ];
    /**
     * @var Response
     */
    private Response $homeResponse;

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return array
     *
     * @throws CookieException
     */
    protected function structureHeaders(array $headers): array
    {
        return array_merge($this->getDefaultHeaders(), $headers);
    }

    /**
     * @return array
     *
     * @throws CookieException
     */
    public function getDefaultHeaders(): array
    {
        if (empty(Config::get('instagram-api.csrf-token'))) {
            dump(Config::get('instagram-api.csrf-token'));

            $this->defineCsrfToken();

            dump(Config::get('instagram-api.csrf-token'));

        }

        return $this->headers;
    }

    /**
     * @return void
     * @throws CookieException
     */
    public function defineCsrfToken()
    {
        $this->homeResponse = $this->home()->execute();

        $this->hasHeader(self::COOKIE_CSRF_KEY);

        $cookieString = $this->getValueInHeader(self::COOKIE_CSRF_KEY, self::COOKIE_CSRF_SLUG);

        $keyValueCsrf = $this->onlyByKey($cookieString, self::COOKIE_CSRF_SLUG);

        $csrfToken = Config::set('instagram-api.csrf-token', $keyValueCsrf->after('='));

        $this->headers = array_merge($this->headers, ['x-csrftoken' => $csrfToken]);
    }

    /**
     * @param string $cookieKey
     *
     * @throws CookieException
     */
    private function hasHeader(string $cookieKey): void
    {
        if (!$this->homeResponse->hasHeader($cookieKey) || !is_iterable($this->homeResponse->getHeader($cookieKey))) {
            throw new CookieException(vprintf('cookie "%s" not found', [$cookieKey]), 1001);
        }
    }

    /**
     * String header of contains csrf token.
     *
     * @param string $keyHeader
     * @param string $partValue
     *
     * @return Stringable
     *
     * @throws CookieException
     */
    private function getValueInHeader(string $keyHeader, string $partValue): Stringable
    {
        $header = collect($this->homeResponse->getHeader($keyHeader))->filter(fn($cookie) => Str::contains($cookie, $partValue));

        if ($header->isEmpty()) {
            throw new CookieException(sprintf('cookie "%s" not found in response header', $keyHeader));
        }

        return Str::of($header->first());
    }

    /**
     * @param Stringable $cookieString
     * @param string $key
     *
     * @return Stringable
     *
     * @throws CookieException
     */
    private function onlyByKey(Stringable $cookieString, string $key): Stringable
    {
        $stringCsrfKeyValue = $cookieString->explode('; ')->filter(fn($cookie) => Str::contains($cookie, $key));

        if ($stringCsrfKeyValue->isEmpty()) {
            throw new CookieException(sprintf('key(%s) not found in header "%s"', $key, self::COOKIE_CSRF_KEY));
        }

        return Str::of($stringCsrfKeyValue->first());
    }
}
