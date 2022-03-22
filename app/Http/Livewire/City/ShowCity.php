<?php

namespace App\Http\Livewire\City;

use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Models\Country;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCity extends Component
{
    use WithPagination;

    public $cca3;
    public $filter = '';
    public $page = 1;
    public $search = '';
    public $uuid;
    public City $cities;
    public Country $country;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public function mount($cca3, $uuid)
    {
        $this->country = Country::findOrFail($this->cca3);
        $this->cities = City::find($this->uuid);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.city.show-city', [
            'country' => $this->country,
            'cities' => $this->cities
                ->hasAddresses()
                ->orderBy('name', 'desc')
                ->paginate(25),
        ]);
    }
}
