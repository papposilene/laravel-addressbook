<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Papposilene\Geodata\Models\Region;

class RegionsUpdater extends Seeder
{
    protected function get_http_response_code($url): string
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

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

        $regions = Region::whereNull('osm_place_id')
            ->orderBy('country_cca3', 'asc')
            ->orderBy('name_eng', 'asc')
            ->get();

        foreach ($regions as $region) {
            echo $region->name_loc . PHP_EOL;

            $nominatim = 'https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email='.$userAgent.'&osmtype=R&osmid=' . $region->osm_id;

            if($this->get_http_response_code($nominatim) != '200') {
                continue;
            }

            $regionJson = file_get_contents($nominatim);
            $regionData = json_decode($regionJson, true);

            $translations = [];
            $getNames = $regionData['names'];
            $getFiltered = array_filter($getNames, function($key) {
                return str_starts_with($key, 'name:');
            }, ARRAY_FILTER_USE_KEY);
            foreach($getFiltered as $key => $value) {
                $lang = explode(':', $key);
                $translations[$lang[1]] = $value;
            }

            $updater = Region::find($region->uuid);
            $updater->region_cca2 = (array_key_exists('ISO3166-2', $regionData['extratags']) ? $regionData['extratags']['ISO3166-2'] : null);
            $updater->osm_place_id = $regionData['place_id'];
            $updater->name_translations = json_encode($translations, JSON_FORCE_OBJECT);
            $updater->extra = [
                'un_locode' => (array_key_exists('ref:LOCODE', $regionData['extratags']) ? $regionData['extratags']['ref:LOCODE'] : null),
                'wikidata' => (array_key_exists('wikidata', $regionData['extratags']) ? $regionData['extratags']['wikidata'] : null),
            ];
            $updater->save();
        }
        sleep(2);
    }
}
