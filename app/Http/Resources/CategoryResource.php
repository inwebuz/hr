<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'name' => $this->getTranslatedAttribute('name'),
            'full_name' => $this->full_name,
            'url' => $this->url,
            'img' => $this->img,
            'small_img' => $this->small_img,
        ];
    }
}
