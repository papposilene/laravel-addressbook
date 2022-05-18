<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AddressesSeeder extends Seeder
{
    private function getEmail()
    {
        // Nominatim's Usage Policy
        // @see https://operations.osmfoundation.org/policies/nominatim/
        return env('MAIL_FROM_ADDRESS', new \Exception('No MAIL_FROM_ADDRESS key into you .env'));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the table
        DB::table('addresses__')->delete();
        DB::table('geodata__cities')->delete();
        DB::table('geodata__regions')->delete();

        foreach (glob(storage_path('data/addresses/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            $country = Country::where('cca3', $json->country_cca3)->firstOrFail();

            foreach ($json->addresses as $data) {
                $isCity = null;
                $isRegion = null;
                $regionLevel = null;
                $cityLevel = null;
                $placeId = $data->geolocation->osm_place_id;

                $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email=' . $this->getEmail() . '&place_id=' . $placeId);
                $dataFile = json_decode($dataJson, true);

                // Retrieve all administrative levels from Nominatim
                $getLevels = $dataFile['address'];
                foreach ($getLevels as $key => $value) {
                    if ($value['osm_type'] === 'R' && $value['place_type'] === 'state') {
                        $regionLevel = $dataFile['address'][$key]['place_id'];
                    }

                    if ($value['osm_type'] === 'R' && $value['place_type'] === 'city') {
                        $cityLevel = $dataFile['address'][$key]['place_id'];
                    }
                }

                if ($regionLevel) {
                    $isRegion = $this->getRegion($regionLevel);
                }

                if ($cityLevel) {
                    $isCity = $this->getCity($cityLevel);
                }

                $subcategory = Subcategory::where('slug', Str::slug($data->category->type, '-'))
                    ->firstOrFail();

                Address::create([
                    'place_name' => Str::of($data->names->name)->trim(),
                    'place_status' => $data->details->status,
                    'address_number' => (!empty($data->address->number) ? $data->address->number : null),
                    'address_street' => (!empty($data->address->street) ? Str::of($data->address->street)->trim() : null),
                    'address_postcode' => (!empty($data->address->postcode) ? Str::of($data->address->postcode)->trim() : null),
                    'address_city' => (!empty($data->address->city) ? Str::of($data->address->city)->trim() : null),
                    'city_uuid' => $isCity->uuid ?? null,
                    'region_uuid' => $isRegion->uuid ?? null,
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
                    'osm_id' => (string)$data->geolocation->osm_id,
                    'gmap_pluscode' => (string)$data->geolocation->gmaps_pluscode,
                ]);
            }
        }
    }

    private function getRegion(int $id)
    {
        $setRegion = null;
        $setRegion = Region::where('osm_place_id', $id)->first();
        if (!is_null($setRegion)) {
            return $setRegion;
        }

        $regionJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?format=json&email=' . $this->getEmail() . '&place_id=' . $id);
        $regionData = json_decode($regionJson, true);

        $setRegion = Region::where('name_slug', Str::slug($regionData['localname'], '-'))->first();
        if (!is_null($setRegion)) {
            return $setRegion;
        }

        $translations = [];
        $getNames = $regionData['names'];
        $getFiltered = array_filter($getNames, function ($key) {
            return str_starts_with($key, 'name:');
        }, ARRAY_FILTER_USE_KEY);
        foreach ($getFiltered as $key => $value) {
            $lang = explode(':', $key);
            $translations[$lang[1]] = $value;
        }

        $isCountry = Country::where('cca2', $regionData['country_code'])->firstOrFail();

        return Region::create([
            'country_cca2' => $isCountry->cca2,
            'country_cca3' => $isCountry->cca3,
            'region_cca2' => (array_key_exists('ISO3166-2', $regionData['extratags']) ? $regionData['extratags']['ISO3166-2'] : null),
            'osm_id' => $regionData['osm_id'],
            'osm_place_id' => $regionData['place_id'],
            'osm_admin_level' => $regionData['admin_level'],
            'osm_type' => $regionData['type'],
            'name_slug' => Str::slug($regionData['localname'], '-'),
            'name_local' => $regionData['localname'],
            'name_translations' => $translations,
            'extra' => [
                'wikidata' => (array_key_exists('wikidata', $regionData['extratags']) ? $regionData['extratags']['wikidata'] : null),
            ],
        ]);
    }

    private function getCity(int $id)
    {
        $setCity = null;
        $setCity = City::where('osm_place_id', $id)->first();
        if (!is_null($setCity)) {
            return $setCity;
        }

        $cityJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?format=json&email=' . $this->getEmail() . '&place_id=' . $id);
        $cityData = json_decode($cityJson, true);

        $setCity = City::where('name_slug', Str::slug($cityData['localname'], '-'))->first();
        if (!is_null($setCity)) {
            return $setCity;
        }

        $translations = [];
        $getNames = $cityData['names'];
        $getFiltered = array_filter($getNames, function ($key) {
            return str_starts_with($key, 'name:');
        }, ARRAY_FILTER_USE_KEY);
        foreach ($getFiltered as $key => $value) {
            $lang = explode(':', $key);
            $translations[$lang[1]] = $value;
        }

        $isCountry = Country::where('cca2', $cityData['country_code'])->firstOrFail();

        return City::create([
            'country_cca3' => $isCountry->cca3,
            'region_uuid' => null,
            'osm_id' => $cityData['osm_id'],
            'osm_place_id' => $cityData['place_id'],
            'osm_admin_level' => $cityData['admin_level'],
            'osm_type' => $cityData['type'],
            'name_slug' => Str::slug($cityData['localname'], '-'),
            'name_local' => $cityData['localname'],
            'name_translations' => $translations,
            'extra' => [
                'wikidata' => (array_key_exists('wikidata', $cityData['extratags']) ? $cityData['extratags']['wikidata'] : null),
            ],
        ]);
    }
}
