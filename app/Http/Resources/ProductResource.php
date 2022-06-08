<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslatedAttribute('name'),
            'url' => $this->url,
            'img' => $this->img,
            'small_img' => $this->small_img,
            'current_price' => $this->current_price,
            'current_price_formatted' => Helper::formatPrice($this->current_price),
        ];
    }
}
