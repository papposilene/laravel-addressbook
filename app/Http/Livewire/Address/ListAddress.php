<?php

namespace App\Http\Livewire\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListAddress extends Component
{
    use WithPagination;

    public string $filter = '';
    public $page = 1;
    public string $search = '';
    protected $addresses;

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
        $addresses = Address::where('country_cca3', 'like', '%'.$this->filter.'%')
            ->where(function($query) {
                $query->where('place_name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->orderBy('place_name', 'asc')
            ->paginate(25);

        return view('livewire.address.list-address', [
            'addresses' => $addresses,
        ]);
    }
}
