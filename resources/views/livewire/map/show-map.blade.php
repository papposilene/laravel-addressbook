@section('title', @ucfirst(__('app.map')))

<div>
    <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
    <i data-fa-symbol="globe" class="fa-solid fa-globe fa-fw text-white"></i>
    <i data-fa-symbol="categories" class="fa-solid fa-clipboard-list fa-fw text-white"></i>
    <i data-fa-symbol="countries" class="fa-solid fa-book-atlas fa-fw text-white"></i>
    <i data-fa-symbol="admin" class="fa-solid fa-gear fa-fw text-white"></i>
    <i data-fa-symbol="caret" class="fa-solid fa-caret-left fa-fw text-white"></i>

    <div class="flex flex-col w-full">
        <div id="leaflet-addresses-map" class="h-screen w-full" wire:ignore></div>

        <div id="sidebar" class="sidebar collapsed font-sans bg-black text-white">
            <!-- Nav tabs -->
            <div class="sidebar-tabs">
                <ul role="tablist">
                    <li>
                        <a href="#home" class="p-2" role="tab">
                            <svg class="h-5 w-5"><use xlink:href="#globe"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#countries" class="p-2" role="tab">
                            <svg class="h-5 w-5"><use xlink:href="#countries"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#categories" class="p-2" role="tab">
                            <svg class="h-5 w-5"><use xlink:href="#categories"></use></svg>
                        </a>
                    </li>
                </ul>

                <ul role="tablist">
                    <li>
                        <a href="{{ route('front.dashboard') }}" class="p-2" role="tab">
                            <svg class="h-5 w-5"><use xlink:href="#admin"></use></svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab panes -->
            <div class="sidebar-content">
                <div class="sidebar-pane" id="home">
                    <h1 class="sidebar-header">
                        {{ config('app.name', 'My Address Book') }}
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h1>

                    <p>A responsive sidebar for mapping libraries like <a href="http://leafletjs.com/">Leaflet</a> or <a href="http://openlayers.org/">OpenLayers</a>.</p>

                    <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

                    <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

                    <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

                    <p class="lorem">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                </div>

                <div class="sidebar-pane" id="countries">
                    <h1 class="sidebar-header">
                        @ucfirst(__('country.countries'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h1>
                    <div class="flex flex-col text-white">
                        @foreach($continents as $continent)
                            <div class="mb-2 px-2 py-2 rounded-lg">
                                <div class="flex justify-start">
                                    {{ $continent->translations }}
                                </div>
                                @foreach($continent->hasCountries()->get() as $country)
                                    @php if($country->hasAddresses()->count() === 0) { continue; } @endphp
                                    <div class="flex w-full px-2">
                                        <a href="{{ route('front.map.index', ['country' => $country->cca3]) }}" class="flex flex-row justify-between m-1 w-full">
                                            <span class="inline-flex align-middle mt-1">
                                                {{ $country->name_translations['common'] }}
                                            </span>
                                            <span class="bg-white text-black text-sm font-semibold inline-flex items-center p-1 rounded-full">
                                                @leadingzero($country->hasAddresses()->count())
                                            </span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-pane" id="categories">
                    <h1 class="sidebar-header">
                        @ucfirst(__('category.categories'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h1>
                    <div class="flex flex-col text-white">
                        @foreach($categories as $category)
                        <div class="mb-2 px-2 py-2 rounded-lg" style="background-color: {{ $category->icon_color }};">
                            <div class="flex justify-start">
                                <i data-fa-symbol="{{ $category->slug }}" class="fas fa-{{ $category->icon_image }} fa-fw"></i>
                                <svg class="h-5 w-5 mr-2">
                                    <use xlink:href="#{{ $category->slug }}"></use>
                                </svg>
                                {{ $category->translations }}
                            </div>
                            @foreach($category->hasSubcategories()->get() as $subcategory)
                            <div class="flex w-full px-2">
                                <a href="{{ route('front.map.index', ['category' => $subcategory->slug]) }}" class="flex flex-row justify-between m-1 w-full">
                                    <span class="inline-flex align-middle mt-1">
                                        <i data-fa-symbol="{{ $subcategory->slug }}" class="fas fa-{{ $subcategory->icon_image }} fa-fw"></i>
                                        <svg class="{{ $subcategory->icon_style }} h-5 w-5 mr-2">
                                            <use xlink:href="#{{ $subcategory->slug }}"></use>
                                        </svg>
                                        {{ $subcategory->translations }}
                                    </span>
                                    <span class="bg-white text-black text-sm font-semibold inline-flex items-center p-1 rounded-full">
                                        @leadingzero($subcategory->hasAddresses()->count())
                                    </span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            @foreach($subcategories as $subcategory)
            const @camel($subcategory->slug)Marker = L.AwesomeMarkers.icon({
                icon: '{{ $subcategory->icon_image }}',
                markerColor: '{{ $subcategory->belongsToCategory->icon_color }}'
            });
            @endforeach

            const leafletMap = L.map('leaflet-addresses-map', {
                center: {{ $center }},
                zoom: {{ $zoom }},
                zoomControl: true
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(leafletMap);

            L.control.locate({
                'enableHighAccuracy': true,
                'flyTo': true,
                strings: {
                    title: "Show me where I am, yo!"
                }
            }).addTo(leafletMap);

            L.control.sidebar('sidebar').addTo(leafletMap);

            async function loadMap() {
                await fetch('{!! $api !!}')
                    .then(response => response.json())
                    .then(json => {
                        json.data.map(function(e) {
                            L.marker([e.address_lat, e.address_lon], {icon: e.marker}).addTo(leafletMap);
                        });
                    });
            }

            loadMap();
        })
    </script>
</div>
