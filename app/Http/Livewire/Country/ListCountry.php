<?php

namespace App\Http\Livewire\Country;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Papposilene\Geodata\Models\Subcontinent;
use Papposilene\Geodata\Models\Country;

class ListCountry extends Component
{
    use WithPagination;

    public string $filter = '';
    public $page = 1;
    public string $search = '';
    public int $withAddresses = 0;
    protected $subcontinents;
    protected $countries;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
        'withAddresses' => ['except' => 0],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->subcontinents = Subcontinent::all();
        $this->countries = Country::where('subcontinent_slug', 'like', '%'.$this->filter.'%')
            ->where(function($query) {
                $query->where('cca2', 'like', '%'.$this->search.'%')
                    ->orWhere('cca3', 'like', '%'.$this->search.'%')
                    ->orWhere('name_eng_common', 'like', '%'.$this->search.'%')
                    ->orWhere('name_eng_formal', 'like', '%'.$this->search.'%')
                    ->orWhere('name_native', 'like', '%'.$this->search.'%')
                    ->orWhere('name_translations', 'like', '%'.$this->search.'%');
            })
            ->orderBy('continent_slug', 'asc')
            ->orderBy('cca3', 'asc')
            ->paginate(25);

        return view('livewire.country.list-country', [
            'subcontinents' => $this->subcontinents,
            'countries' => $this->countries
        ]);
    }
}
