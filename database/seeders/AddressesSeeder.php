<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Subcategory;
use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;
use Geocoder\Provider\Nominatim\Nominatim;
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
        // Nominatim's Usage Policy
        // @see https://operations.osmfoundation.org/policies/nominatim/
        $userAgent = env('MAIL_FROM_ADDRESS', new \Exception('No MAIL_FROM_ADDRESS key into you .env'));

        // Drop the table
        DB::table('addresses__')->delete();
        DB::table('geodata__cities')->delete();

        foreach (glob(storage_path('data/addresses/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            $country = Country::where('cca3', $json->country_cca3)->firstOrFail();

            foreach ($json->addresses as $data) {
                echo $data->names->name . PHP_EOL;
                $cityOsmId = null;
                $cityPlaceId = null;
                $placeId = $data->geolocation->osm_place_id;

                $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email='.$userAgent.'&place_id=' . $placeId);
                $dataFile = json_decode($dataJson, true);

                // Get the postal code
                foreach ($dataFile['address'] as $key => $value) {
                    if ($value['type'] === 'postcode') {
                        $postcode = $dataFile['address'][$key]['localname'];
                    }
                }

                $isCity = City::where([
                    'country_cca3' => $country->cca3,
                    'name_local' => $data->address->city,
                ])->first();

                if(!is_null($isCity)) {
                    $city = $isCity;
                } else {
                    $cityJson = file_get_contents('https://nominatim.openstreetmap.org/search.php?limit=1&format=jsonv2&extratags=1&namedetails=1email='.$userAgent.'&countrycodes='.$data->address->country_cca3.'&city=' . $cityPlaceId);
                    $cityData = json_decode($cityJson, true);

                    $translations = [];
                    $getNames = $cityData['names'];
                    $getFiltered = array_filter($getNames, function($key) {
                        return str_starts_with($key, 'name:');
                    }, ARRAY_FILTER_USE_KEY);
                    foreach($getFiltered as $key => $value) {
                        $lang = explode(':', $key);
                        $translations[$lang[1]] = $value;
                    }

                    $region = Region::where('country_cca3', $country->cca3)
                        ->where(function($query) use ($cityData) {
                            $query->where('region_cca2', $cityData['extratags']['ISO3166-2'])
                                ->orWhere('description', 'like', '%'.$this->search.'%');
                        })->first();

                    $city = City::firstOrCreate(
                        [
                            'country_cca3' => $country->cca3,
                            'osm_place_id' => $cityPlaceId,
                        ],
                        [
                            'region_uuid' => $region->uuid,
                            'osm_id' => $cityData['osm_id'],
                            'osm_place_id' => $cityData['place_id'],
                            'osm_admin_level' => $cityData['admin_level'],
                            'osm_type' => $cityData['type'],
                            'name_local' => $cityData['localname'],
                            'name_translations' => json_encode($translations, JSON_FORCE_OBJECT),
                            'postcodes' => null,
                            'extra' => [
                                'wikidata' => (array_key_exists('wikidata', $cityData['extratags']) ? $cityData['extratags']['wikidata'] : null),
                            ],
                        ]
                    );
                }

                $subcategory = Subcategory::where('slug', Str::slug($data->category->type, '-'))
                    ->firstOrFail();

                Address::create([
                    'place_name' => Str::of($data->names->name)->trim(),
                    'place_status' => $data->details->status,
                    'address_number' => (!empty($data->address->number) ? $data->address->number : null),
                    'address_street' => (!empty($data->address->street) ? Str::of($data->address->street)->trim() : null),
                    'address_postcode' => (!empty($data->address->postcode) ? Str::of($data->address->postcode)->trim() : null),
                    'city_uuid' => $city->uuid,
                    'region_uuid' => $city->region_uuid,
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
