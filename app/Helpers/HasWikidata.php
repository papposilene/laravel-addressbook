<?php

use Illuminate\Support\Str;

if (!function_exists('hasWikidata')) {
    /**
     * Check if an address with a Wikidata id has already its Wikipedia article in the database.
     *
     * @param string $uuid The uuid of any address
     * @param string $wikidata The Wikidata id
     * @return string|null The uuid of the stored Wikipedia article
     */
    function hasWikidata(string $uuid, string $wikidata): ?string
    {
        $lang = app()->getLocale();
        $cache = \App\Models\Wikidata::where('wikidata_id', $wikidata)->first();

        if (is_null($cache)) {
            $dataJson = file_get_contents('https://www.wikidata.org/w/api.php?action=wbgetentities&format=json&props=sitelinks&ids=' . $wikidata);
            $dataFile = json_decode($dataJson, true);
            if (array_key_exists($lang . 'wiki', $dataFile['entities'][$wikidata]['sitelinks'])) {
                $title = $dataFile['entities'][$wikidata]['sitelinks'][$lang . 'wiki']['title'];
            }
            elseif (array_key_exists('enwiki', $dataFile['entities'][$wikidata]['sitelinks'])) {
                $lang = 'en';
                $title = $dataFile['entities'][$wikidata]['sitelinks']['enwiki']['title'];
            } else {
                return null;
            }

            $pediaJson = file_get_contents('https://' . $lang . '.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=' . urlencode($title));
            $pediaFile = json_decode($pediaJson, true);
            $pagesid = array_keys($pediaFile['query']['pages']);
            $pediaData = $pediaFile['query']['pages'][$pagesid[0]];

            $cache = \App\Models\Wikidata::create([
                'address_uuid' => $uuid,
                'wikidata_id' => $wikidata,
                'wikipedia_pid' => $pediaData['pageid'],
                'wikipedia_link' => 'https://' . $lang . '.wikipedia.org/wiki/' . Str::replace(' ', '_', $pediaData['title']),
                'wikipedia_title' => [
                    $lang => $pediaData['title'],
                ],
                'wikipedia_text' => [
                    $lang => $pediaData['extract'],
                ],
            ]);
        }

        return $cache->uuid;
    }
}

