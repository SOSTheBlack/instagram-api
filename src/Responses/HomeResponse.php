<?php

namespace Sostheblack\InstagramApi\Responses;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class HomeResponse
 *
 * @package Sostheblack\InstagramApi\Responses
 */
class HomeResponse extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Response
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return ['headers' => $this->resource->getHeaders()];
    }
}
