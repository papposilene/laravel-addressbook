<?php

namespace App\Http\Livewire\Map;

use App\Models\Category;
use App\Models\City;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Subcategory;
use Filament\Forms;
use Illuminate\Http\Request;
use Livewire\Component;

class ShowMap extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $category, $city, $country;
    public string $apiGeo, $apiSearch;
    public string $center = '[25, 0]';
    public string $search = '';
    public float $zoom = 2.5;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('country')
                ->label(ucfirst(__('country.countries')))
                ->options(
                    Country::withCount('hasAddresses')
                        ->orderBy('name_eng_common', 'asc')
                        ->get()
                        ->where('has_addresses_count', '>', 0)
                        ->pluck('name_eng_common', 'cca3')
                )
                ->autofocus()
                ->searchable(),
            Forms\Components\Select::make('category')
                ->label(ucfirst(__('category.categories')))
                ->options(
                    Subcategory::orderBy('slug', 'asc')
                        ->pluck('translations', 'slug')
                )
                ->searchable(),
        ];
    }

    public function mount(Request $request): void
    {
        $requestedCategory = $request->query('category');
        $requestedCity = $request->query('city');
        $requestedCountry = $request->query('country');

        if ($requestedCategory) {
            $this->category = Subcategory::findOrFail($requestedCategory);
        }

        if ($requestedCity) {
            $this->city = City::findOrFail($requestedCity);
        }

        if ($requestedCountry) {
            $this->country = Country::findByCca3($requestedCountry);
        }

        $this->form->fill([
            'category' => $this->category->slug ?? null,
            //'city' => $this->address->uuid ?? null,
            'country' => $this->country->cca3 ?? null,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        $search = $this->form->getState();

        return redirect()->route('front.index', [
            'category' => $search['category'] ?? null,
            'city' => $search['city'] ?? null,
            'country' => $search['country'] ?? null,
        ]);
    }

    public function render(Request $request)
    {
        $requestedCategory = $request->get('category', null);
        $requestedCity = $request->get('city', null);
        $requestedCountry = $request->get('country', null);

        $hasRequest = $requestedCategory ?? $requestedCity ?? $requestedCountry;

        if ($requestedCountry) {
            $country = Country::where('cca3', $requestedCountry)->firstOrFail();
            $this->center = '[' . $country->lon . ', ' . $country->lat . ']';
            $this->zoom = 6;
        }

        $this->categories = Category::withCount('hasAddresses')
            ->orderBy('has_addresses_count', 'desc')
            ->get();
        $this->continents = Continent::orderBy('name', 'asc')
            ->get();
        $this->subcategories = Subcategory::all();

        $this->apiGeo = route('api.address.geojson', [
            'category' => $requestedCategory,
            'city' => $requestedCity,
            'country' => $requestedCountry,
        ]);

        $this->apiSearch = route('api.address.search', ['q' => $this->search]);

        return view('livewire.map.show-map', [
            'apiGeo' => $this->apiGeo,
            'apiSearch' => $this->apiSearch,
            'center' => $this->center,
            'countries' => $this->continents,
            'categories' => $this->categories,
            'hasRequest' => $hasRequest,
            'subcategories' => $this->subcategories,
            'zoom' => $this->zoom,
        ])->layout('layouts.map');
    }
}
