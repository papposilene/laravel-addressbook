<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Support\Str;

if (!function_exists('getCity'))
{
    /**
     * Check if an Open Street Map region exists, and then create it
     *
     * @param array $id An array with osm_id and the osm_type
     * @return City|null The City model
     */
    function getCity(array $id, ?Region $isRegion)
    {
        $setCity = City::where('osm_id', $id)->first();
        if (!is_null($setCity)) {
            return $setCity;
        }

        $cityJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?format=json&email=' . getNominatimEmail() . '&osmtype=' . $id['osm_type'] . '&osmid=' . $id['osm_id']);
        $cityData = json_decode($cityJson, true);

        $setCity = City::where('name_slug', Str::slug($cityData['localname'], '-'))->first();
        if (!is_null($setCity)) {
            return $setCity;
        }

        $translations = [];
        $getNames = $cityData['names'];
        $getFiltered = array_filter($getNames, function ($key) {
            return (str_starts_with($key, 'name:') && !str_ends_with($key, ':pronunciation'));
        }, ARRAY_FILTER_USE_KEY);
        foreach ($getFiltered as $key => $value) {
            $lang = explode(':', $key);
            $translations[$lang[1]] = $value;
        }

        $isCountry = Country::where('cca2', $cityData['country_code'])->firstOrFail();

        return City::create([
            'country_cca3' => $isCountry->cca3,
            'region_uuid' => $isRegion->uuid ?? null,
            'osm_id' => $id['osm_type'] . $id['osm_id'],
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
