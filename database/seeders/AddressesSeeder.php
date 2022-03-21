<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

            foreach ($json->regions->addresses as $data)
            {
                $subcategory = Subcategory::where('name', $data->category->type)
                    ->orWhere('slug', Str::slug($data->category->type, '-'))
                    ->firstOrFail();

                $city = City::where([
                    ['country_cca3', $country->cca3],
                    ['name', $data->address->city],
                ])->firstOrFail();

                Address::create([
                    'place_name' => $data->names->name,
                    'place_status' => $data->details->status,
                    'address_number' => (int) $data->address->number,
                    'address_street' => (string) $data->address->street,
                    'address_postcode' => (string) $data->address->postcode,
                    'address_city' => $city->uuid,
                    'address_country' => $country->cca3,
                    'address_lat' => (float) $data->geolocation->lat,
                    'address_lon' => (float) $data->geolocation->lon,
                    'description' => $data->details->description,
                    'details' => json_encode([
                            'opening_hours' => $data->details->opening_hours,
                            'phone' => $data->details->phone,
                            'website' => $data->details->website,
                            'wikidata' => $data->details->wikidata,
                        ], JSON_FORCE_OBJECT),
                    'subcategory_slug' => $subcategory->slug,
                    'osm_id' => (int) $data->geolocation->osm_id,
                    'osm_place_id' => (int) $data->geolocation->osm_place_id,
                    'gmap_pluscode' => (string) $data->geolocation->gmaps_pluscode,
                ]);
            }
        }
    }
}
