<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Country;
use App\Models\Subcategory;
use Livewire\Component;

class ShowLanding extends Component
{

    protected $categories;
    protected $countries;

    public function render()
    {
        $this->categories = Subcategory::withCount('hasAddresses')
            ->orderBy('has_addresses_count', 'desc')
            ->get();
        $this->countries = Country::withCount('hasAddresses')
            ->orderBy('cca3', 'asc')
            ->get();

        return view('livewire.dashboard.show-landing', [
            'categories' => $this->categories->where('has_addresses_count', '>=', 1),
            'countries' => $this->countries->where('has_addresses_count', '>=', 1),
        ]);
    }
}
