<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $hasWikidata = (!is_null($this->details['wikidata']) ? hasWikidata($this->uuid, $this->details['wikidata']) : null);

        return [
            'uuid' => $this->uuid,
            'place_name' => $this->place_name,
            'place_status' => $this->place_status,
            'address_number' => $this->address_number,
            'address_street' => $this->address_street,
            'address_postcode' => $this->address_postcode,
            'address_city' => $this->address_city,
            'address_lat' => $this->address_lat,
            'address_lon' => $this->address_lon,

            'region' => $this->belongsToRegion,
            'country' => [
                'cca2' => $this->belongsToCountry->cca2,
                'cca3' => $this->belongsToCountry->cca3,
                'name_formal' => $this->belongsToCountry->name_eng_common,
                'name_common' => $this->belongsToCountry->name_eng_formal,
                'lat' => $this->belongsToCountry->lat,
                'lon' => $this->belongsToCountry->lon,
            ],

            'description' => $this->description,
            'details' => $this->details,

            'wikipedia' => [
                'link' => ($this->hasWikipedia ? $this->hasWikipedia->wikipedia_link : null),
                'summary' => ($this->hasWikipedia ? $this->hasWikipedia->wikipedia_text : null),
            ],

            'category' => [
                'name' => $this->belongsToCategory->name,
                'slug' => $this->belongsToCategory->slug,
                'camelSlug' => Str::camel($this->belongsToCategory->slug),
                'icon_image' => $this->belongsToCategory->icon_image,
                'icon_style' => $this->belongsToCategory->icon_style,
                'icon_color' => $this->belongsToCategory->icon_color,
            ],
            'subcategory' => [
                'name' => $this->belongsToSubcategory->name,
                'slug' => $this->belongsToSubcategory->slug,
                'camelSlug' => Str::camel($this->belongsToSubcategory->slug),
                'icon_image' => $this->belongsToSubcategory->icon_image,
                'icon_style' => $this->belongsToSubcategory->icon_style,
                'icon_color' => $this->belongsToSubcategory->icon_color,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
