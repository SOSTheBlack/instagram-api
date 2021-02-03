<?php
namespace Sostheblack\InstagramApi;

use JetBrains\PhpStorm\Pure;

/**
 * @param  string  $myString
 * @param  string  $separator
 *
 * @return bool|string
 */
#[Pure]
function str_after(string $myString, string $separator): bool|string
{
    return substr($myString, strpos($myString, $separator) + 1);
}
