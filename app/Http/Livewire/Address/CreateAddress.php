<?php

namespace App\Http\Livewire\Address;

use App\Models\Address;
use App\Models\Country;
use App\Models\Subcategory;
use Filament\Forms;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateAddress extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Address $address;

    public $category = '';
    public $place_name, $place_status;
    public $address_number, $address_street, $address_postcode, $address_city, $address_lat, $address_lon;
    public $city_uuid, $region_uuid, $cca3, $category_slug, $osm_id;
    public $description, $details;

    protected function getFormModel(): string
    {
        return Address::class;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make(ucfirst(__('address.nameHeading')))
                ->description(ucfirst(__('address.nameDescription')))
                ->schema([
                    Forms\Components\TextInput::make('place_name')
                        ->label(ucfirst(__('address.name')))
                        ->placeholder('Musée du Louvre')
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label(ucfirst(__('address.description')))
                        ->placeholder('Musée du Louvre'),
                    Forms\Components\Select::make('place_status')
                        ->label(ucfirst(__('address.status')))
                        ->options([
                            '1' => ucfirst(__('address.status_open')),
                            '0' => ucfirst(__('address.status_close')),
                        ])
                        ->default('1')
                        ->required(),
                    Forms\Components\Select::make('subcategory_slug')
                        ->label(ucfirst(__('category.categories')))
                        ->options(Subcategory::orderBy('slug', 'asc')->pluck('translations', 'slug'))
                        ->searchable()
                        ->required(),
                ])->columns(1),
            Forms\Components\Section::make(ucfirst(__('address.addressHeading')))
                ->description(ucfirst(__('address.addressDescription')))
                ->schema([
                    Forms\Components\TextInput::make('address_lat')
                        ->label(ucfirst(__('address.latitude')))
                        ->placeholder('48.860646512951334')
                        ->required(),
                    Forms\Components\TextInput::make('address_lon')
                        ->label(ucfirst(__('address.longitude')))
                        ->placeholder('2.337661796776722')
                        ->required(),
                    Forms\Components\TextInput::make('address_number')
                        ->label(ucfirst(__('address.streetnumber')))
                        ->placeholder('99'),
                    Forms\Components\TextInput::make('address_street')
                        ->label(ucfirst(__('address.streetname')))
                        ->placeholder('Rue de Rivoli'),
                    Forms\Components\TextInput::make('address_postcode')
                        ->label(ucfirst(__('address.postcode')))
                        ->placeholder('75001'),
                    Forms\Components\TextInput::make('address_city')
                        ->label(ucfirst(__('address.city')))
                        ->placeholder('Paris')
                        ->required(),
                    Forms\Components\Select::make('cca3')
                        ->label(ucfirst(__('country.countries')))
                        ->options(Country::orderBy('name_eng_common', 'asc')->pluck('name_eng_common', 'cca3'))
                        ->searchable()
                        ->required(),
                ])->columns(2),
            Forms\Components\Section::make(ucfirst(__('address.detailsHeading')))
                ->description(ucfirst(__('address.detailsDescription')))
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label(ucfirst(__('address.phone')))
                        ->placeholder('+33140205317'),
                    Forms\Components\TextInput::make('website')
                        ->label(ucfirst(__('address.website')))
                        ->placeholder('https://www.louvre.fr/'),
                    Forms\Components\TextInput::make('wikidata')
                        ->label(ucfirst(__('address.wikidata')))
                        ->placeholder('Q19675'),
                    Forms\Components\TextInput::make('osm_id')
                        ->label(ucfirst(__('address.osmid')))
                        ->placeholder('R7515426'),
                ])->columns(2),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        $answers = $this->form->getState();

        if ($answers['osm_id']) {
            $osmType = substr($answers['osm_id'], 0, 1);
            $osmId = substr($answers['osm_id'], 1);

            $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email=' . getNominatimEmail() . '&osmtype=' . $osmType . '&osmid=' . $osmId);
            $dataFile = json_decode($dataJson, true);

            // Retrieve all administrative levels from Nominatim
            $regionLevel = [];
            $cityLevel = [];
            $getLevels = $dataFile['address'];
            foreach ($getLevels as $key => $value) {
                if ($value['osm_type'] === 'R' && ($value['place_type'] === 'state' || $value['place_type'] === 'province')) {
                    $regionLevel['osm_type'] = $dataFile['address'][$key]['osm_type'];
                    $regionLevel['osm_id'] = $dataFile['address'][$key]['osm_id'];
                }

                if ($value['osm_type'] === 'R' && ($value['place_type'] === 'city' || $value['type'] === 'city')) {
                    $cityLevel['osm_type'] = $dataFile['address'][$key]['osm_type'];
                    $cityLevel['osm_id'] = $dataFile['address'][$key]['osm_id'];
                }

                if(empty($cityLevel) && $regionLevel) {
                    $cityLevel['osm_type'] = $dataFile['address'][$key-2]['osm_type'];
                    $cityLevel['osm_id'] = $dataFile['address'][$key-2]['osm_id'];
                }
            }

            $isRegion = null;
            if ($regionLevel) {
                $isRegion = getRegion($regionLevel);
            }

            if ($cityLevel) {
                $isCity = getCity($cityLevel, $isRegion);
            }
        }

        $isCountry = Country::where('cca3', $answers['cca3'])->firstOrFail();

        $address = new Address();
        $address->place_name = Str::of($answers['place_name'])->trim();
        $address->place_status = $answers['place_status'];
        $address->address_number = Str::of($answers['address_number'])->trim();
        $address->address_street = Str::of($answers['address_street'])->trim();
        $address->address_postcode = Str::of($answers['address_postcode'])->trim();
        $address->address_city = Str::of($answers['address_city'])->trim();
        $address->city_uuid = $isCity->uuid ?? null;
        $address->region_uuid = $isRegion->uuid ?? null;
        $address->country_cca3 = $isCountry->cca3;
        $address->address_lat = Str::of($answers['address_lat'])->trim();
        $address->address_lon = Str::of($answers['address_lon'])->trim();
        $address->details = [
            'phone' => Str::of($answers['phone'])->trim() ?? null,
            'website' => Str::of($answers['website'])->trim() ?? null,
            'wikidata' => Str::of($answers['wikidata'])->trim() ?? null,
        ];
        $address->description = Str::of($answers['description'])->trim();
        $address->subcategory_slug = $answers['subcategory_slug'];
        $address->osm_id = Str::of($answers['osm_id'])->trim();
        $address->save();

        session()->flash('message', 'Address successfully created.');
        return redirect()->to('/addresses');
    }

    public function render()
    {
        return view('livewire.address.create-address');
    }
}
