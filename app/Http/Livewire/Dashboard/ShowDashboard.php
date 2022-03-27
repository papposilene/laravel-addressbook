<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Address;
use App\Models\Category;
use App\Models\City;
use App\Models\Subcategory;
use Livewire\Component;
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\Subcontinent;

class ShowDashboard extends Component
{
    public function render()
    {
        $continents = Continent::all();
        $subcontinents = Subcontinent::all();
        $countries = Country::all();
        $cities = City::all();
        $addresses = Address::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('livewire.dashboard.show-dashboard', [
            'continents' => $continents,
            'subcontinents' => $subcontinents,
            'countries' => $countries,
            'cities' => $cities,
            'addresses' => $addresses,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }
}
