<?php

namespace App\Http\Livewire\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowAddress extends Component
{
    public string $filter = '';
    public $page = 1;
    public string $search = '';
    public string $uuid;
    protected $address;
    protected $suggestions;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->address = Address::findOrFail($this->uuid);
        $this->suggestions = Address::where('place_status', true)
            ->where(function($query) {
                $query->where('address_city', $this->address->address_city)
                    ->orWhere('country_cca3', $this->address->country_cca3);
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('livewire.address.show-address', [
            'address' => $this->address,
            'suggestions' => $this->suggestions,
        ]);
    }
}
