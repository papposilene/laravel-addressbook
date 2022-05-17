@section('title', @ucfirst(__('app.map')))

<div>
    <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
    <i data-fa-symbol="globe" class="fa-solid fa-globe fa-fw text-white"></i>
    <i data-fa-symbol="categories" class="fa-solid fa-clipboard-list fa-fw text-white"></i>
    <i data-fa-symbol="countries" class="fa-solid fa-book-atlas fa-fw text-white"></i>
    <i data-fa-symbol="addresses-info" class="fa-solid fa-circle-info fa-fw text-white"></i>
    <i data-fa-symbol="admin" class="fa-solid fa-gear fa-fw text-white"></i>
    <i data-fa-symbol="caret" class="fa-solid fa-caret-left fa-fw text-white"></i>

    <i data-fa-symbol="phone" class="fa-solid fa-phone fa-fw text-white"></i>
    <i data-fa-symbol="website" class="fa-solid fa-link fa-fw text-white"></i>
    <i data-fa-symbol="hours" class="fa-solid fa-clock fa-fw text-white"></i>
    <i data-fa-symbol="address" class="fa-solid fa-signs-post fa-fw text-white"></i>
    <i data-fa-symbol="wikipedia" class="fa-brands fa-wikipedia-w fa-fw text-white"></i>

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
                    <li>
                        <a href="#address-informations" class="p-2" role="tab">
                            <svg class="h-5 w-5"><use xlink:href="#addresses-info"></use></svg>
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

                <div class="sidebar-pane" id="address-informations">
                    <h1 class="sidebar-header">
                        @ucfirst(__('app.informations'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h1>
                    <div class="flex flex-col text-white" id="address-informations-content">
                        <p>Pour obtenir des informations sur une adresse, veuillez en sélectionner une sur la carte.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            @foreach($subcategories as $subcategory)
            const @camel($subcategory->slug)Marker = L.AwesomeMarkers.icon({
                prefix: 'fa',
                icon: '{{ $subcategory->icon_image }}',
                markerColor: '{{ $subcategory->belongsToCategory->icon_color }}'
            });
            @endforeach

            const leafletMap = L.map('leaflet-addresses-map', {
                center: {{ $center }},
                zoom: {{ $zoom }},
                zoomControl: false
            });

            L.control.zoom({
                position: 'topright'
            }).addTo(leafletMap);


            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(leafletMap);

            L.control.locate({
                enableHighAccuracy: true,
                flyTo: true,
                position: 'topright',
                strings: {
                    title: "@ucfirst(__('app.map_whereiam'))"
                }
            }).addTo(leafletMap);

            L.control.sidebar('sidebar').addTo(leafletMap);

            async function loadMap() {
                await fetch('{!! $api !!}')
                    .then(response => response.json())
                    .then(json => {
                        json.data.map(function(e) {
                            L.marker([e.address_lat, e.address_lon], {uuid: e.uuid, data: e})
                                .addTo(leafletMap)
                                .on("click", function (e) { setContent(`
<p class="mt-3 font-semibold text-lg">${this.options.data.place_name}</p>
<p class="mt-5 font-sans">${this.options.data.description}</p>
<ul class="mt-5 px-1 text-sm text-slate-500 font-mono">
    ${this.options.data.details.phone ? '<li class="inline-flex w-full align-middle pb-1"><svg class="h-4 w-4 mr-2"><use xlink:href="#phone"></use></svg><a href="tel:'+this.options.data.details.phone+'">'+this.options.data.details.phone+'</a></li>' : ''}
    ${this.options.data.details.website ? '<li class="inline-flex w-full align-middle py-1"><svg class="h-4 w-4 mr-2"><use xlink:href="#website"></use></svg><a href="'+this.options.data.details.website+'" target="_blank">'+this.options.data.details.website+'</a></li>' : ''}
    <li class="inline-flex w-full align-middle py-1">
        <svg class="h-4 w-4 mr-2"><use xlink:href="#address"></use></svg>
        ${this.options.data.address_number} ${this.options.data.address_street}<br />
        ${this.options.data.address_postcode} ${this.options.data.address_city}
    </li>
    ${this.options.data.details.opening_hours ? '<li class="inline-flex w-full align-middle py-1"><svg class="h-4 w-4 mr-2"><use xlink:href="#hours"></use></svg>'+this.options.data.details.opening_hours+'</li>' : ''}
</ul>
${this.options.data.wikipedia ? '<p class="inline-flex w-full align-middle pt-1 pr-3 text-slate-500"><svg class="h-4 w-4 mr-2"><use xlink:href="#wikipedia"></use></svg>'+this.options.data.wikipedia+'</p>' : ''}
                            ` )});
                        });
                    });
            }

            function setContent(content) {
                const container = L.DomUtil.get('address-informations-content');

                if (typeof content === 'string') {
                    container.innerHTML = content;
                } else {
                    while (container.firstChild) {
                        container.removeChild(container.firstChild);
                    }
                    container.appendChild(content);
                }

                L.DomUtil.addClass(container, 'active');

                return this;
            }

            loadMap();
        })
    </script>
</div>
