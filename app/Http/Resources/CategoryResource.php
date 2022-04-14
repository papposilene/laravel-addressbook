<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'name' => $this->name,
            'icon_image' => $this->icon_image,
            'icon_style' => $this->icon_style,
            'icon_color' => $this->icon_color,
            'descriptions' => $this->descriptions,
            'translations' => $this->translations,

            'has_subcategories_count' => $this->hasSubcategories()->count(),
            'has_addresses_count' => $this->hasAddresses()->count(),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
