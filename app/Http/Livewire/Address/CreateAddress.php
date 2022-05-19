<?php

namespace App\Http\Livewire\Address;

use App\Models\Address;
use App\Models\Country;
use App\Models\Subcategory;
use Filament\Forms;
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
                    Forms\Components\Textinput::make('place_name')
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
                    Forms\Components\TextInput::make('lat')
                        ->label(ucfirst(__('address.latitude')))
                        ->placeholder('48.860646512951334')
                        ->required(),
                    Forms\Components\TextInput::make('lon')
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

    private function getEmail(): string
    {
        // Nominatim's Usage Policy
        // @see https://operations.osmfoundation.org/policies/nominatim/
        return env('MAIL_FROM_ADDRESS', new \Exception('No MAIL_FROM_ADDRESS key into your .env'));
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

            $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email=' . $this->getEmail() . '&osmtype=' . $osmType . '&osmid=' . $osmId);
            $dataFile = json_decode($dataJson, true);



        } else {

        }

        dd($answers);

        $isCity = City::first();
        $isRegion = Region::first();
        $isCountry = Country::where('cca3', $answers['cca3'])->firstOrFail();

        $address = new Address();
        $address->place_name = $answers['name'];
        $address->place_status = $answers['status'];
        $address->address_number = $answers['number'];
        $address->address_street = $answers['street'];
        $address->address_postcode = $answers['postcode'];
        $address->address_city = $answers['city'];
        $address->city_uuid = $isCity->uuid ?? null;
        $address->region_uuid = $isRegion->uuid ?? null;
        $address->country_cca3 = $isCountry->cca3;
        $address->address_lat = $answers['latitude'];
        $address->address_lon = $answers['longitude'];
        $address->details = [
            'phone' => $answers['phone'] ?? null,
            'website' => $answers['website'] ?? null,
            'wikidata' => $answers['wikidata'] ?? null,
        ];
        $address->description = $answers['description'];
        $address->subcategory_slug = $answers['subcategory_slug'];
        $address->osm_id = $answers['osm_id'];
        $address->save();

        session()->flash('message', 'Address successfully created.');
        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.address.create-address');
    }
}
