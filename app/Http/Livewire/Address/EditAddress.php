<?php

namespace App\Http\Livewire\Address;

use App\Models\Address;
use App\Models\Country;
use App\Models\Subcategory;
use Filament\Forms;
use Illuminate\Support\Str;
use Livewire\Component;

class EditAddress extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Address $address;

    public $category = '';
    public $uuid, $place_name, $place_status;
    public $address_number, $address_street, $address_postcode, $address_city, $address_lat, $address_lon;
    public $city_uuid, $region_uuid, $cca3, $category_slug, $osm_id;
    public $description, $details;

    public function mount(string $uuid): void
    {
        $this->address = Address::findOrFail($uuid);

        $this->form->fill([
            'uuid' => $this->address->uuid,
            'place_name' => $this->address->place_name,
            'place_status' => $this->address->place_status,
            'address_number' => $this->address->address_number,
            'address_street' => $this->address->address_street,
            'address_postcode' => $this->address->address_postcode,
            'address_city' => $this->address->address_city,
            'city_uuid' => $this->address->city_uuid,
            'region_uuid' => $this->address->region_uuid,
            'cca3' => $this->address->country_cca3,
            'address_lat' => $this->address->address_lat,
            'address_lon' => $this->address->address_lon,
            'description' => $this->address->description,
            'phone' => $this->address->details['phone'],
            'website' => $this->address->details['website'],
            'wikidata' => $this->address->details['wikidata'],
            'subcategory_slug' => $this->address->subcategory_slug,
            'osm_id' => $this->address->osm_id,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Hidden::make('uuid'),
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
                        ->options(Subcategory::orderBy('slug', 'asc')->pluck('name', 'slug'))
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

        $address = Address::findOrFail($answers['uuid']);
        $address->place_name = Str::trim($answers['place_name']);
        $address->place_status = $answers['place_status'];
        $address->address_number = Str::trim($answers['address_number']);
        $address->address_street = Str::trim($answers['address_street']);
        $address->address_postcode = Str::trim($answers['address_postcode']);
        $address->address_city = Str::trim($answers['address_city']);
        $address->city_uuid = $isCity->uuid ?? null;
        $address->region_uuid = $isRegion->uuid ?? null;
        $address->country_cca3 = $isCountry->cca3;
        $address->address_lat = Str::trim($answers['address_lat']);
        $address->address_lon = Str::trim($answers['address_lon']);
        $address->details = [
            'phone' => Str::trim($answers['phone']) ?? null,
            'website' => Str::trim($answers['website']) ?? null,
            'wikidata' => Str::trim($answers['wikidata']) ?? null,
        ];
        $address->description = Str::trim($answers['description']);
        $address->subcategory_slug = $answers['subcategory_slug'];
        $address->osm_id = Str::trim($answers['osm_id']);
        $address->save();

        session()->flash('message', 'Address successfully updated.');
        return redirect()->to('/address/' . $address->uuid);
    }

    public function render()
    {
        return view('livewire.address.edit-address');
    }
}
