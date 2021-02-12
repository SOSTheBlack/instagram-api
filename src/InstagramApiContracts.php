<?php

namespace Sostheblack\InstagramApi;

/**
 * Class InstagramApiContracts
 *
 * @package Sostheblack\InstagramApi
 */
interface InstagramApiContracts
{
    /**
     * @const string COOKIE_CSRF_KEY
     */
    public const COOKIE_CSRF_KEY = 'Set-Cookie';

    /**
     * @const string COOKIE_CSRF_SLUG
     */
    public const COOKIE_CSRF_SLUG = 'csrftoken';

    /**
     * Storage disk key.
     *
     * @const string STORAGE_DISK
     */
    public const STORAGE_DISK = 'instagram-api';
}
