<?php

namespace App\Http\Livewire\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListAddress extends Component
{
    use WithPagination;

    public $filter = '';
    public $page = 1;
    public $search = '';
    public Address $address;

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
        if (Auth::check() && Auth::user()->can('publish addresses'))
        {
            return;
        }

        $addresses = Address::where('place_name', 'like', '%'.$this->search.'%')
            ->orderBy('place_name', 'desc')
            ->paginate(25);

        return view('livewire.address.list-address', [
            'addresses' => $addresses,
        ]);
    }
}
