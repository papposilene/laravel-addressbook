<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCountry extends Component
{
    use WithPagination;

    public string $cca3;
    public string $filter = '';
    public $page = 1;
    public string $search = '';
    public int $withAddresses = 0;
    protected $cities;
    protected $country;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
        'withAddresses' => ['except' => 0],
    ];

    public function mount($cca3)
    {
        $this->cca3 = $cca3;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->country = Country::where('cca3', $this->cca3)->firstOrFail();
        $this->cities = City::where('country_cca3', $this->cca3)
            ->orderBy('region_uuid', 'asc')
            ->orderBy('name_local', 'asc')
            ->withCount('hasAddresses')
            ->has('hasAddresses', '>=', $this->withAddresses)
            ->paginate(25);

        return view('livewire.country.show-country', [
            'lang' => app()->getLocale(),
            'country' => $this->country,
            'cities' => $this->cities,
        ]);
    }
}
