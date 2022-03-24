<?php

namespace App\Http\Livewire\Interfaces;

use App\Models\Wikidata;
use Livewire\Component;

class Wikipedia extends Component
{
    public string $address_uuid;
    public string $wikidata;

    public function mount($address_uuid, $wikidata)
    {
        $this->address_uuid = $address_uuid;
        $this->wikidata = $wikidata;
    }

    public function render()
    {
        $slug = $this->wikidata;
        $cache = Wikipedia::where('wikidata_id', $slug)->first();

        if(is_null($cache)) {
            $lang = app()->getLocale();
            $dataJson = file_get_contents('https://www.wikidata.org/w/api.php?action=wbgetentities&format=json&props=sitelinks&ids=' . $slug);
            $dataFile = json_decode($dataJson, true);
            if(property_exists($dataFile['entities'][$slug]['sitelinks'], $lang . 'wiki')) {
                $title = $dataFile['entities'][$slug]['sitelinks'][$lang . 'wiki'];
            } else {
                $lang = 'en';
                $title = $dataFile['entities'][$slug]['sitelinks']['enwiki'];
            }

            $pediaJson = file_get_contents('https://' . $lang . '.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=' . urlencode($title));
            $pediaFile = json_decode($pediaJson, true);
            $pediaData = $pediaFile['entities'][$this->wikidata]['sitelinks'][$lang . 'wiki'];

            dd($pediaData);

            $cache = Wikidata::create([
                'address_uuid' => $this->address_uuid,
                'wikidata_id' => $slug,
                'wikidata_pid' => $pediaData,
                'wikidata_text' => $pediaData,
            ]);


        }

        $this->wikipedia = $cache->wikipedia_text;

        dd($this->wikipedia);

        return view('livewire.interfaces.wikipedia', [
            'wikipedia' => $this->wikidata,
        ]);
    }
}
