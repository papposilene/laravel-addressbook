<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use App\Models\Subcategory;
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
        DB::table('geodata__cities')->delete();
        DB::table('geodata__regions')->delete();

        foreach (glob(storage_path('data/addresses/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            $country = Country::where('cca3', $json->country_cca3)->firstOrFail();

            foreach ($json->addresses as $data) {
                $isCity = null;
                $isRegion = null;
                $regionLevel = [];
                $cityLevel = [];
                $osmId = $data->geolocation->osm_id;

                $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email=' . getNominatimEmail() . '&osmtype=' . substr($osmId, 0, 1) . '&osmid=' . substr($osmId, 1));
                $dataFile = json_decode($dataJson, true);

                // Retrieve all administrative levels from Nominatim
                $getLevels = $dataFile['address'];
                foreach ($getLevels as $key => $value) {
                    if ($value['osm_type'] === 'R' && ($value['place_type'] === 'state' || $value['place_type'] === 'province')) {
                        $regionLevel['osm_type'] = $dataFile['address'][$key]['osm_type'];
                        $regionLevel['osm_id'] = $dataFile['address'][$key]['osm_id'];
                    }

                    if ($value['osm_type'] === 'R' && ($value['place_type'] === 'city' || $value['type'] === 'city')) {
                        $cityLevel['osm_type'] = $dataFile['address'][$key]['osm_type'];
                        $cityLevel['osm_id'] = $dataFile['address'][$key]['osm_id'];
                    }

                    if(empty($cityLevel) && $regionLevel) {
                        $cityLevel['osm_type'] = $dataFile['address'][$key-2]['osm_type'];
                        $cityLevel['osm_id'] = $dataFile['address'][$key-2]['osm_id'];
                    }
                }

                if ($regionLevel) {
                    $isRegion = getRegion($regionLevel);
                }

                if ($cityLevel) {
                    $isCity = getCity($cityLevel, $isRegion);
                }

                $subcategory = Subcategory::where('slug', Str::slug($data->category->type, '-'))
                    ->firstOrFail();

                Address::create([
                    'place_name' => Str::of($data->name)->trim(),
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
                        'phone' => $data->details->phone,
                        'website' => $data->details->website,
                        'wikidata' => $data->details->wikidata,
                    ],
                    'subcategory_slug' => $subcategory->slug,
                    'osm_id' => (string)$data->geolocation->osm_id,
                ]);
            }
        }
    }
}
