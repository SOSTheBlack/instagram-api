<?php


namespace Sostheblack\InstagramApi\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

/**
 * Class InstagramApiException
 *
 * @package Sostheblack\InstagramApi\Exceptions
 */
class InstagramApiException extends Exception implements Throwable
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link https://php.net/manual/en/exception.construct.php
     *
     * @param  string  $message  [optional] The Exception message to throw.
     * @param  int  $code  [optional] The Exception code.
     * @param  Throwable|null  $previous  [optional] The previous throwable used for the exception chaining.
     */
    #[Pure]
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}