@section('title', @ucfirst(__('address.create_one')))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('address.create_one'))
            </span>
        </h2>
    </x-slot>

    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="icons" class="fas fa-icons fa-fw"></i>
        <i data-fa-symbol="create" class="fas fa-plus fa-fw text-green-500"></i>
        <i data-fa-symbol="delete" class="fas fa-trash fa-fw text-red-500"></i>
        <i data-fa-symbol="edit" class="fas fa-pencil fa-fw text-blue-500"></i>
        <i data-fa-symbol="favorite" class="fas fa-star fa-fw text-yellow-500"></i>
        <i data-fa-symbol="show" class="fas fa-magnifying-glass-arrow-right fa-fw text-green-600"></i>

        <div class="flex flex-col lg:flex-row-reverse w-full lg:max-w-7xl lg:mx-auto py-5 px-6">
            <div class="flex flex-col pl-2 pr-2 w-full lg:mx-auto lg:w-2/4">
                @if ($errors->any())
                    <div class="bg-red-400 border border-red-600 mb-5 p-3 text-white font-bold rounded shadow">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Create form -->
                <div class="py-5">
                    <form wire:submit.prevent="submit">
                        <div class="col-span-full mb-6">
                            <div class="p-6 space-y-6 bg-white rounded-xl border border-gray-300 filament-forms-section-component">
                                <div id="leaflet-geocoder" class="flex h-96 pb-5" wire:ignore></div>
                            </div>
                        </div>


                        {{ $this->form }}

                        <div class="flex flex-inline justify-end space-x-4 pt-5">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                @ucfirst(__('app.save'))
                            </button>
                        </div>
                    </form>
                </div>
                <!-- End of create form -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            const map = L.map('leaflet-geocoder').setView([25, 0], 2.5);
            L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            L.Control.geocoder({
                collapsed: false,
                errorMessage: '@ucfirst(__('app.nothing'))',
                placeholder: '@ucfirst(__('app.search'))',
                showResultIcons: true,
                NominatimOptions: { countrycodes: 'pt' }
            }).on('markgeocode', function(e) {
                const name = e.geocode.properties.display_name.split(',');
                @this.$set('place_name', name[0]);
                @this.$set('address_number', e.geocode.properties.address.housenumber);
                @this.$set('address_street', e.geocode.properties.address.road);
                @this.$set('address_postcode', e.geocode.properties.address.postcode);
                @this.$set('address_city', e.geocode.properties.address.city ?? e.geocode.properties.address.county);
                @this.$set('address_lat', e.geocode.properties.lat);
                @this.$set('address_lon', e.geocode.properties.lon);
                @this.$set('osm_id', e.geocode.properties.osm_type.charAt(0).toUpperCase() + e.geocode.properties.osm_id);
                @this.$set('wikidata', e.geocode.properties.wikidata);
            }).addTo(map);
        })
    </script>
</div>
