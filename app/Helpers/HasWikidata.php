<?php

namespace App\Helpers;

if (!function_exists('hasWikipedia')) {
    /**
     * Check if an address with a Wikidata id has already its Wikipedia article in the database.
     *
     * @param string $uuid The uuid of any address
     * @param string $wikidata The Wikidata id
     * @return string The uuid of the stored Wikipedia article
     */
    function hasWikipedia(string $uuid, string $wikidata): string
    {
        $lang = app()->getLocale();
        $cache = \App\Models\Wikidata::where('wikidata_id', $wikidata)->first();

        if (is_null($cache)) {
            $dataJson = file_get_contents('https://www.wikidata.org/w/api.php?action=wbgetentities&format=json&props=sitelinks&ids=' . $slug);
            $dataFile = json_decode($dataJson, true);
            if ($dataFile['entities'][$wikidata]['sitelinks'][$lang . 'wiki']) {
                $title = $dataFile['entities'][$wikidata]['sitelinks'][$lang . 'wiki']['title'];
            } else {
                $lang = 'en';
                $title = $dataFile['entities'][$wikidata]['sitelinks']['enwiki']['title'];
            }

            $pediaJson = file_get_contents('https://' . $lang . '.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=' . urlencode($title));
            $pediaFile = json_decode($pediaJson, true);
            $pagesid = array_keys($pediaFile['query']['pages']);
            $pediaData = $pediaFile['query']['pages'][$pagesid[0]];

            $cache = \App\Models\Wikidata::create([
                'address_uuid' => $uuid,
                'wikidata_id' => $wikidata,
                'wikipedia_pid' => $pediaData['pageid'],
                'wikipedia_title' => $pediaData['title'],
                'wikipedia_text' => $pediaData['extract'],
            ]);
        }

        return $cache->uuid;
    }
}

