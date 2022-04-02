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
use Papposilene\Geodata\Models\Region;

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

            foreach ($json->addresses as $data) {
                $cityModel = null;
                $cityName = null;
                $region = null;
                $placeId = $data->geolocation->osm_place_id;
                $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&hierarchy=0&group_hierarchy=1&format=json&place_id=' . $placeId);
                $dataFile = json_decode($dataJson, true);

                // Get the postal code
                foreach ($dataFile['address'] as $key => $value) {
                    if (in_array('postcode', $value)) return $keyPostcode;
                }
                $postcode = $dataFile['address'][$keyPostcode]['localname'];

                //$addrPostcode = $dataFile['address'];

                dd($dataFile);

                $foundCity = City::where([
                    ['country_cca3', $country->cca3],
                    ['name', $data->address->city],
                ])->first();


                $subcategory = Subcategory::where('slug', Str::slug($data->category->type, '-'))
                    ->firstOrFail();

                Address::create([
                    'place_name' => Str::of($data->names->name)->trim(),
                    'place_status' => $data->details->status,
                    'address_number' => (!empty($data->address->number) ? $data->address->number : null),
                    'address_street' => (!empty($data->address->street) ? $data->address->street : null),
                    'address_postcode' => (!empty($data->address->postcode) ? $data->address->postcode : null),
                    'address_city' => $cityName,
                    'address_country' => $country->name_eng_common,
                    'city_uuid' => $cityModel,
                    'region_uuid' => $region,
                    'country_cca3' => $country->cca3,
                    'address_lat' => (float)$data->geolocation->lat,
                    'address_lon' => (float)$data->geolocation->lon,
                    'description' => Str::of($data->details->description)->trim(),
                    'details' => [
                        'opening_hours' => $data->details->opening_hours,
                        'phone' => $data->details->phone,
                        'website' => $data->details->website,
                        'wikidata' => $data->details->wikidata,
                    ],
                    'subcategory_slug' => $subcategory->slug,
                    'osm_place_id' => (int)$data->geolocation->osm_place_id,
                    'gmap_pluscode' => (string)$data->geolocation->gmaps_pluscode,
                ]);
            }
        }
    }
}
