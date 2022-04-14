<?php

namespace App\Http\Livewire\Map;

use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Livewire\Component;
use Papposilene\Geodata\Models\Continent;

class ShowMap extends Component
{
    public string $api;
    public string $center = '[0, 0]';
    public int $zoom = 4;

    public function render(Request $request)
    {
        $cca3 = $request->get('country', null);
        $region = $request->get('region', null);
        $category = $request->get('category', null);

        if($cca3) {
            $country = Country::where('cca3', $cca3)->firstOrFail();
            $this->center = '['.$country->lon.', '.$country->lat.']';
            $this->zoom = 6;
        }

        $this->categories = Category::withCount('hasAddresses')
            ->orderBy('has_addresses_count', 'desc')
            ->get();
        $this->continents = Continent::orderBy('name', 'asc')
            ->get();

        $this->api = route('api.address.index', [
            'country' => $cca3,
            'region' => $region,
            'category' => $category
        ]);

        return view('livewire.map.show-map', [
            'api' => $this->api,
            'center'=> $this->center,
            'countries' => $this->continents,
            'categories' => $this->categories,
            'zoom'=> $this->zoom,
        ])->layout('layouts.map');
    }
}
