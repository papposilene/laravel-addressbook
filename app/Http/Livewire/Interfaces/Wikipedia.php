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

        $storedArticle = hasWikidata($this->address_uuid, $slug);
        $wikipedia = Wikidata::find($storedArticle);

        return view('livewire.interfaces.wikipedia', [
            'wikipedia' => $wikipedia,
        ]);
    }
}
