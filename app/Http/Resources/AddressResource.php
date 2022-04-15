<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'uuid' => $this->uuid,
            'osm_place_id' => $this->osm_place_id,
            'gmap_pluscode' => $this->gmap_pluscode,
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
                //'uuid' => $this->belongsToCountry->uuid,
                'cca2' => $this->belongsToCountry->cca2,
                'cca3' => $this->belongsToCountry->cca3,
                'name_formal' => $this->belongsToCountry->name_eng_common,
                'name_common' => $this->belongsToCountry->name_eng_formal,
                'lat' => $this->belongsToCountry->lat,
                'lon' => $this->belongsToCountry->lon,

            ],

            'description' => $this->description,

            'category' => $this->belongsToCategory,
            'subcategory' => $this->belongsToSubcategory,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
