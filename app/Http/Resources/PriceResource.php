<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $params = parent::toArray($request);
        // Remove unnecessary information
        unset($params['id'], $params['from'], $params['to']);

        return $params;
    }
}
