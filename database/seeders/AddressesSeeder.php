<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
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

            $country = Country::where('cca3', $file->extension())->firstOrFail();

            foreach ($json->regions->addresses as $data)
            {
                $subcategory = Subcategory::where('name', $data->category->type)
                    ->orWhere('slug', $data->category->type)
                    ->first();

                $city = City::where([
                    ['country_cca3', $country->cca3],
                    ['name', $data->address->city],
                ])->first();

                Address::create([
                    'place_name' => $data->names->name,
                    'place_status' => $data->names,
                    'address_number' => (int) $data->address->number,
                    'address_street' => (string) $data->address->street,
                    'address_postcode' => (string) $data->address->postcode,
                    'address_city' => $city->name,
                    'address_country' => $country->cca3,
                    'address_lat' => (string) $data->geolocation->lat,
                    'address_lon' => (string) $data->geolocation->lon,
                    'details' => json_encode($data->details, JSON_FORCE_OBJECT),
                    'subcategory_slug' => $subcategory->slug,
                    'osm_id' => (int) $data->geolocation->osm_id,
                    'osm_place_id' => (int) $data->geolocation->osm_place_id,
                    'gmap_pluscode' => (string) $data->geolocation->gmaps_pluscode,
                ]);
            }
        }
    }
}
