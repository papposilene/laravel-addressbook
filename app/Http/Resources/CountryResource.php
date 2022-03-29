<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'continent' => [
                'id' => $this->belongsToContinent->id,
                'slug' => $this->belongsToContinent->slug,
                'name' => $this->belongsToContinent->name,
            ],
            'subcontinent' => [
                'id' => $this->belongsToSubcontinent->id,
                'slug' => $this->belongsToSubcontinent->slug,
                'name' => $this->belongsToSubcontinent->name,
            ],
            'cca2' => $this->cca2,
            'cca3' => $this->cca3,
            'name_eng_formal' => $this->name_eng_formal,
            'name_eng_common' => $this->name_eng_common,
            'flag' => $this->flag,
            'lat' => $this->lat,
            'lon' => $this->lon,

            'has_addresses_count' => $this->has_addresses_count,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
