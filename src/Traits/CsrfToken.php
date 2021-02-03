<?php

namespace Sostheblack\InstagramApi\Traits;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Sostheblack\InstagramApi\Exceptions\CookieException;

/**
 * Trait CsrfToken
 *
 * @package Sostheblack\InstagramApi\Traits
 */
trait CsrfToken
{
    /**
     * @var Response
     */
    private Response $homeResponse;

    /**
     * @return void
     * @throws CookieException
     */
    public function defineCsrfToken()
    {
        $this->homeResponse = $this->home()->execute()->resource;

        $this->hasCookie(self::COOKIE_CSRF_KEY);

        $cookieString = $this->getValueInHeader(self::COOKIE_CSRF_KEY, self::COOKIE_CSRF_SLUG);

        $keyValueCsrf = $this->onlyByKey($cookieString,self::COOKIE_CSRF_SLUG);

        $this->csrfToken = $keyValueCsrf->after('=');
    }

    /**
     * @param  string  $cookieKey
     *
     * @throws CookieException
     */
    private function hasCookie(string $cookieKey): void
    {
        if (! $this->homeResponse->hasHeader($cookieKey) || ! is_iterable($this->homeResponse->getHeader($cookieKey))) {
            throw new CookieException(vprintf('cookie "%s" not found', [$cookieKey]), 1001);
        }
    }

    /**
     * String header of contains csrf token.
     *
     * @param  string  $keyHeader
     * @param  string  $partValue
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
     * @param  Stringable  $cookieString
     * @param  string  $key
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
