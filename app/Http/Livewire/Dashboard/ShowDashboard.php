<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Address;
use App\Models\Category;
use App\Models\Country;
use App\Models\Subcategory;
use Livewire\Component;
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Subcontinent;

class ShowDashboard extends Component
{
    public function render()
    {
        $continents = Continent::all();
        $subcontinents = Subcontinent::all();
        $countries = Country::all();
        $addresses = Address::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('livewire.dashboard.show-dashboard', [
            'addresses' => $addresses,
            'categories' => $categories,
            'continents' => $continents,
            'countries' => $countries,
            'subcategories' => $subcategories,
            'subcontinents' => $subcontinents,
        ]);
    }
}
