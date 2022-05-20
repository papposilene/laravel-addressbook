<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Support\Str;

if (!function_exists('getRegion'))
{
    /**
     * Check if an address with a Wikidata id has already its Wikipedia article in the database.
     *
     * @param string $uuid The uuid of any address
     * @param string $wikidata The Wikidata id
     * @return string|null The uuid of the stored Wikipedia article
     */

    public function getRegion(array $id)
    {
        $setRegion = Region::where('osm_id', $id['osm_type'] . $id['osm_id'])->first();
        if (!is_null($setRegion)) {
            return $setRegion;
        }

        $regionJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?format=json&email=' . $this->getEmail() . '&osmtype=' . $id['osm_type'] . '&osmid=' . $id['osm_id']);
        $regionData = json_decode($regionJson, true);

        $setRegion = Region::where('name_slug', Str::slug($regionData['localname'], '-'))->first();
        if (!is_null($setRegion)) {
            return $setRegion;
        }

        $translations = [];
        $getNames = $regionData['names'];
        $getFiltered = array_filter($getNames, function ($key) {
            return (str_starts_with($key, 'name:') && !str_ends_with($key, ':pronunciation'));
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
            'osm_id' => $id['osm_type'] . $id['osm_id'],
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

}
