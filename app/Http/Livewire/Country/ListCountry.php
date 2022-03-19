<?php

namespace App\Http\Livewire\Country;

use Papposilene\Geodata\Models\Country;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListCountry extends Component
{
    use WithPagination;

    public $filter = '';
    public $page = 1;
    public $search = '';
    public Country $country;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $countries = Country::where('cca3', 'like', '%'.$this->search.'%')
            ->orderBy('cca3', 'asc')
            ->paginate(25);

        return view('livewire.country.list-country', [
            'countries' => $countries,
        ]);
    }
}
