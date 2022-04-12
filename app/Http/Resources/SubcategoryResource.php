<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
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
            'descriptions' => $this->descriptions,
            'translations' => $this->translations,
            'category' => [
                'uuid' => $this->belongsToCategory->uuid,
                'slug' => $this->belongsToCategory->slug,
                'name' => $this->belongsToCategory->name,
                'icon_image' => $this->belongsToCategory->icon_image,
                'icon_style' => $this->belongsToCategory->icon_style,
                'descriptions' => $this->belongsToCategory->descriptions,
                'translations' => $this->belongsToCategory->translations,
            ],
            'addresses' => $this->hasAddresses()->paginate(25),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
