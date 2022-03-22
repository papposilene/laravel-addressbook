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
    public $withAddresses = 0;
    protected $countries;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
        'withAddresses' => ['except' => 0],
    ];

    public function mount()
    {
        $this->countries = Country::where('cca2', 'like', '%'.$this->search.'%')
            ->orWhere('cca3', 'like', '%'.$this->search.'%')
            ->orWhere('name_eng_common', 'like', '%'.$this->search.'%')
            ->orWhere('name_eng_formal', 'like', '%'.$this->search.'%')
            ->orWhere('name_native', 'like', '%'.$this->search.'%')
            ->orWhere('name_translations', 'like', '%'.$this->search.'%')
            ->orderBy('cca3', 'asc')
            //->withCount('hasAddresses')
            //->has('hasAddresses', '>=', $this->withAddresses)
            ->paginate(25);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.country.list-country', [
            'countries' => $this->countries
        ]);
    }
}
