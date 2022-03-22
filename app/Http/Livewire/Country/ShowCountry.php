<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCountry extends Component
{
    use WithPagination;

    public $filter = '';
    public $page = 1;
    public $search = '';
    public $withAddresses = 0;
    public City $cities;
    public Country $country;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
        'withAddresses' => ['except' => 0],
    ];

    public function mount($cca3)
    {
        $this->country = Country::firstOrFail($cca3);
        $this->cities = City::where('country_cca3', $cca3)
            ->orderBy('name', 'asc')
            ->withCount('hasAddresses')
            ->has('hasAddresses', '>=', $this->withAddresses)
            ->paginate(25);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.country.show-country', [
            'country' => $this->country,
            'cities' => $this->cities,
        ]);
    }
}
