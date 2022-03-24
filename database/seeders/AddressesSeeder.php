<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Models\Country;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the table
        DB::table('addresses__')->delete();

        foreach (glob(storage_path('data/addresses/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            $country = Country::where('cca3', $json->country_cca3)->firstOrFail();

            foreach ($json->regions as $region)
            {
                foreach ($region->addresses as $data) {
                    $subcategory = Subcategory::where('slug', Str::slug($data->category->type, '-'))
                        ->firstOrFail();

                    $city = City::where([
                        ['country_cca3', $country->cca3],
                        ['name', $data->address->city],
                    ])->first();

                    Address::create([
                        'place_name' => Str::of($data->names->name)->trim(),
                        'place_status' => $data->details->status,
                        'address_number' => (!empty($data->address->number) ? $data->address->number : null),
                        'address_street' => (!empty($data->address->street) ? $data->address->street : null),
                        'address_postcode' => (!empty($data->address->postcode) ? $data->address->postcode : null),
                        'address_city' => (!empty($data->address->city) ? $data->address->city : null),
                        'address_country' => $country->name_eng_common,
                        'city_uuid' => ($city ? $city->uuid : null),
                        'country_cca3' => $country->cca3,
                        'address_lat' => (float) $data->geolocation->lat,
                        'address_lon' => (float) $data->geolocation->lon,
                        'description' => Str::of($data->details->description)->trim(),
                        'details' => json_encode([
                            'opening_hours' => $data->details->opening_hours,
                            'phone' => $data->details->phone,
                            'website' => $data->details->website,
                            'wikidata' => $data->details->wikidata,
                        ], JSON_FORCE_OBJECT),
                        'subcategory_slug' => $subcategory->slug,
                        'osm_id' => (int)$data->geolocation->osm_id,
                        'osm_place_id' => (int)$data->geolocation->osm_place_id,
                        'gmap_pluscode' => (string)$data->geolocation->gmaps_pluscode,
                    ]);
                }
            }
        }
    }
}
