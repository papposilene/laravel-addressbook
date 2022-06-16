@section('title', @ucfirst(__('app.map')))

<div>
    <style>
        .leaflet-loader-container {
            height: 100%;
            width: 100%;
            position: absolute;
            z-index: 1000;
            cursor: auto;
        }
        .leaflet-loader-container .leaflet-loader-background {
            position:fixed;
            height: 100%;
            width: 100%;
            background-color: rgba(0,0,0,0.9);
        }

        .leaflet-loader {
            width:57.6px;
            margin: 30em auto;
        }

        @-webkit-keyframes hideLoader {
            from {opacity: 1;}
            to {opacity: 0;}
        }
        @keyframes hideLoader {
            from {opacity: 1;}
            to {opacity: 0;}
        }

        /*
        Following css for the loading animations comes from :
        https://connoratherton.com/loaders
        */

        @-webkit-keyframes scale {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1; }

            45% {
                -webkit-transform: scale(0.1);
                transform: scale(0.1);
                opacity: 0.7; }

            80% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1; } }
        @keyframes scale {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1; }

            45% {
                -webkit-transform: scale(0.1);
                transform: scale(0.1);
                opacity: 0.7; }

            80% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1; } }

        .leaflet-loader > div:nth-child(0) {
            -webkit-animation: scale 0.75s -0.36s infinite cubic-bezier(.2, .68, .18, 1.08);
            animation: scale 0.75s -0.36s infinite cubic-bezier(.2, .68, .18, 1.08); }
        .leaflet-loader > div:nth-child(1) {
            -webkit-animation: scale 0.75s -0.24s infinite cubic-bezier(.2, .68, .18, 1.08);
            animation: scale 0.75s -0.24s infinite cubic-bezier(.2, .68, .18, 1.08); }
        .leaflet-loader > div:nth-child(2) {
            -webkit-animation: scale 0.75s -0.12s infinite cubic-bezier(.2, .68, .18, 1.08);
            animation: scale 0.75s -0.12s infinite cubic-bezier(.2, .68, .18, 1.08); }
        .leaflet-loader > div:nth-child(3) {
            -webkit-animation: scale 0.75s 0s infinite cubic-bezier(.2, .68, .18, 1.08);
            animation: scale 0.75s 0s infinite cubic-bezier(.2, .68, .18, 1.08); }
        .leaflet-loader > div {
            background-color: #fff;
            width: 15px;
            height: 15px;
            border-radius: 100%;
            margin: 2px;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            display: inline-block; }
    </style>

    <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
    <i data-fa-symbol="about" class="fa-solid fa-address-card fa-fw text-white"></i>
    <i data-fa-symbol="addresses-info" class="fa-solid fa-circle-info fa-fw text-white"></i>
    <i data-fa-symbol="admin" class="fa-solid fa-gear fa-fw text-white"></i>
    <i data-fa-symbol="caret" class="fa-solid fa-caret-left fa-fw text-white"></i>
    <i data-fa-symbol="categories" class="fa-solid fa-clipboard-list fa-fw text-white"></i>
    <i data-fa-symbol="countries" class="fa-solid fa-book-atlas fa-fw text-white"></i>
    <i data-fa-symbol="globe" class="fa-solid fa-globe fa-fw text-white"></i>
    <i data-fa-symbol="search" class="fa-solid fa-search fa-fw text-white"></i>

    <i data-fa-symbol="phone" class="fa-solid fa-phone fa-fw text-white"></i>
    <i data-fa-symbol="website" class="fa-solid fa-link fa-fw text-white"></i>
    <i data-fa-symbol="hours" class="fa-solid fa-clock fa-fw text-white"></i>
    <i data-fa-symbol="address" class="fa-solid fa-signs-post fa-fw text-white"></i>
    <i data-fa-symbol="wikipedia" class="fa-brands fa-wikipedia-w fa-fw text-white"></i>

    <div class="flex flex-col w-full">
        <div id="leaflet-addresses-map" class="h-screen w-full" wire:ignore></div>

        <div id="sidebar" class="sidebar collapsed font-sans bg-black text-white z-10000" wire:ignore>
            <!-- Nav tabs -->
            <div class="sidebar-tabs">
                <ul role="tablist">
                    <li>
                        <a href="{{ route('front.index') }}" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'Home']);">
                            <svg class="h-5 w-5"><use xlink:href="#globe"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#addresses-lookup" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'Lookup']);">
                            <svg class="h-5 w-5"><use xlink:href="#search"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#countries" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'Countries']);">
                            <svg class="h-5 w-5"><use xlink:href="#countries"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#categories" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'Categories']);">
                            <svg class="h-5 w-5"><use xlink:href="#categories"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#address-informations" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'Address Informations']);">
                            <svg class="h-5 w-5"><use xlink:href="#addresses-info"></use></svg>
                        </a>
                    </li>
                </ul>

                <ul role="tablist">
                    <li>
                        <a href="#about" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'About']);">
                            <svg class="h-5 w-5"><use xlink:href="#about"></use></svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.dashboard') }}" class="p-2" role="tab"
                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Menu', 'Dashboard']);">
                            <svg class="h-5 w-5"><use xlink:href="#admin"></use></svg>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab panes -->
            <div class="sidebar-content">
                <div class="sidebar-pane" id="about">
                    <div class="flex flex-col h-screen">
                        <h1 class="sidebar-header">
                            {{ config('app.name', 'My Address Book') }}
                            <span class="sidebar-close p-2">
                                <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                            </span>
                        </h1>
                        <div class="flex-grow">
                            <p class="my-6 text-2xl">
                                Carnet de bonnes adresses
                            </p>
                            <p class="my-2">
                                Les adresses référencées sur cette carte sont le fruit de glanage lors de voyage ou de discussions.
                            </p>
                            <p class="my-2">
                                Certaines peuvent être périmées ou pire avoir perdu de leur saveur, auquel cas j'en suis le premier désolé.
                                Le cas échéant, n'hésitez pas à m'en informer que la déception ne se propage pas trop.
                            </p>
                        </div>
                        <div class="relative -t-5 b-5 px-1 text-xs text-slate-500 font-mono">
                            Conçu artisanalement avec les outils Laravel 9, Livewire 2, Tailwind CSS 3, FontAwesome 6 et Leaflet 1.8.
                            Le code source de cette application web est <a href="https://github.com/papposilene/laravel-addressbook" target="_blank">disponible sur Github</a>.
                        </div>
                    </div>
                </div>

                <div class="sidebar-pane" id="addresses-lookup">
                    <h2 class="sidebar-header">
                        @ucfirst(__('app.search'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h2>
                    <div class="flex flex-col text-white">
                        <form wire:submit.prevent="submit">
                            {{ $this->form }}

                            <div class="flex flex-inline justify-end space-x-4 pt-5">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    @ucfirst(__('app.search'))
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="sidebar-pane" id="countries">
                    <h2 class="sidebar-header">
                        @ucfirst(__('country.countries'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h2>
                    <div class="flex flex-col text-white">
                        @foreach($continents as $continent)
                            <div class="mb-2 px-2 py-2 rounded-lg">
                                <div class="flex justify-start">
                                    {{ $continent->translations }}
                                </div>
                                @foreach($continent->hasCountries()->get() as $country)
                                    @php if($country->hasAddresses()->count() === 0) { continue; } @endphp
                                    <div class="flex w-full px-2">
                                        <a href="{{ route('front.index', ['country' => $country->cca3]) }}" class="flex flex-row justify-between m-1 w-full"
                                           onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Countries', '{{ $country->cca3 }}']);">
                                            <span class="inline-flex align-middle mt-1">
                                                {{ $country->flag }}
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
                    <h2 class="sidebar-header">
                        @ucfirst(__('category.categories'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h2>
                    <div class="flex flex-col text-white">
                        @foreach($categories as $category)
                        <div class="mb-2 px-2 py-2 rounded-lg" style="background-color: {{ $category->icon_color }};">
                            <div class="flex justify-start">
                                <i data-fa-symbol="{{ $category->slug }}" class="fa-solid fa-{{ $category->icon_image }} fa-fw"></i>
                                <svg class="h-5 w-5 mr-2">
                                    <use xlink:href="#{{ $category->slug }}"></use>
                                </svg>
                                {{ $category->translations }}
                            </div>
                            @foreach($category->hasSubcategories()->get() as $subcategory)
                            <div class="flex w-full px-2">
                                <a href="{{ route('front.index', ['category' => $subcategory->slug]) }}" class="flex flex-row justify-between m-1 w-full"
                                   onclick="_paq.push(['trackEvent', 'Map', 'Sidebar', 'Categories', '{{ $subcategory->translations }}']);">
                                    <span class="inline-flex align-middle mt-1">
                                        <i data-fa-symbol="{{ $subcategory->slug }}" class="fa-solid fa-{{ $subcategory->icon_image }} fa-fw"></i>
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
                    <h2 class="sidebar-header">
                        @ucfirst(__('app.informations'))
                        <span class="sidebar-close p-2">
                            <svg class="h-5 w-5"><use xlink:href="#caret"></use></svg>
                        </span>
                    </h2>
                    <div class="flex flex-col text-white" id="address-informations-content">
                        <p>Pour obtenir des informations sur une adresse, veuillez en sélectionner une sur la carte.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            @if($hasRequest)
            function setContent(content, place_name, country, category, subcategory) {
                const sidebar = L.DomUtil.get('sidebar');
                const container = L.DomUtil.get('address-informations');
                const contenter = L.DomUtil.get('address-informations-content');

                if (typeof content === 'string') {
                    contenter.innerHTML = content;
                } else {
                    while (contenter.firstChild) {
                        container.removeChild(contenter.firstChild);
                    }
                    container.appendChild(contenter);
                }

                L.DomUtil.addClass(container, 'active');
                if (L.DomUtil.hasClass(sidebar, 'collapsed')) {
                    L.DomUtil.removeClass(sidebar, 'collapsed');
                }

                _paq.push(['trackEvent', 'Map', 'Marker', 'Country', country]);
                _paq.push(['trackEvent', 'Map', 'Marker', 'Address', place_name]);
                _paq.push(['trackEvent', 'Map', 'Marker', 'Category', category]);
                _paq.push(['trackEvent', 'Map', 'Marker', 'Subcategory', subcategory]);

                return this;
            }
            @endif

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
            @if($hasRequest)
            L.Control.Loader = L.Control.extend({
                options: {
                },
                onAdd: function (map) {
                    this.container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                    this.loaderContainer = L.DomUtil.create('div', 'leaflet-loader-container', this._map._container);
                    this.loaderBG = L.DomUtil.create('div', 'leaflet-loader-background', this.loaderContainer);
                    this.loader = L.DomUtil.create('div', 'leaflet-loader', this.loaderBG);
                    for (i=0; i<3; i++) {
                        L.DomUtil.create('div', '', this.loader);
                    }

                    this._map.dragging.disable();
                    this._map.touchZoom.disable();
                    this._map.doubleClickZoom.disable();
                    this._map.scrollWheelZoom.disable();

                    return this.container;
                },
                hide: function () {
                    this.loaderBG.style.animation ="hideLoader 1s";
                    this.loaderBG.style.webkitAnimationName ="hideLoader 1s";
                    this.loaderBG.style.opacity ="0";

                    var _this = this;
                    setTimeout(function (){_this.loaderContainer.style.display ="none";},500);
                    this._map.dragging.enable();
                    this._map.touchZoom.enable();
                    this._map.doubleClickZoom.enable();
                    this._map.scrollWheelZoom.enable();
                }
            });

            L.control.loader = function(options) {
                return new L.Control.Loader(options);
            };

            const loader = L.control.loader().addTo(leafletMap);

            fetch('{!! $apiGeo !!}')
                .then(res => res.json())
                .then(data => {
                    L.geoJSON(data, {
                        pointToLayer: function (feature) {
                            return L.marker(
                                [feature.geometry.coordinates[0], feature.geometry.coordinates[1]],
                                {
                                    data: feature.properties,
                                    icon: L.icon.fontAwesome({
                                        iconClasses: 'h-4 w-4 fa-solid fa-location-dot',
                                        iconYOffset: -7,
                                        markerColor: feature.properties.category.icon_color,
                                    })
                                }
                            ).on("click", function (e) { setContent(`
<h3 class="mt-3 font-semibold text-lg">${this.options.data.name}</h3>
<p class="mt-5 font-sans py-0.5 px-1.5 rounded-lg ${this.options.data.category.icon_style}">
    ${this.options.data.category.name} /
    ${this.options.data.subcategory.name}
</p>
<p class="mt-5 font-sans">${this.options.data.description ?? '&nbsp;'}</p>
<ul class="mt-5 px-1 text-sm text-slate-500 font-mono">
    ${this.options.data.details.phone ? '<li class="inline-flex w-full align-middle pb-1"><svg class="h-4 w-4 mr-2"><use xlink:href="#phone"></use></svg><a href="tel:'+this.options.data.details.phone+'">'+this.options.data.details.phone+'</a></li>' : ''}
    ${this.options.data.details.website ? '<li class="inline-flex w-full align-middle py-1"><svg class="h-4 w-4 mr-2"><use xlink:href="#website"></use></svg><a href="'+this.options.data.details.website+'" target="_blank">'+this.options.data.details.website+'</a></li>' : ''}
    <li class="inline-flex w-full align-middle py-1">
        <svg class="h-4 w-4 mr-2"><use xlink:href="#address"></use></svg>
        ${this.options.data.address_number ?? ''} ${this.options.data.address_street ?? ''}<br />
        ${this.options.data.address_postcode ?? ''} ${this.options.data.address_city}
    </li>
    ${this.options.data.details.opening_hours ? '<li class="inline-flex w-full align-middle py-1"><svg class="h-4 w-4 mr-2"><use xlink:href="#hours"></use></svg>'+this.options.data.details.opening_hours+'</li>' : ''}
</ul>
${this.options.data.wikipedia.summary ? '<p class="w-full pt-1 pr-3 text-slate-500">'+this.options.data.wikipedia.summary+'<br /><br />Plus d’informations sur Wikipedia : <a href="'+this.options.data.wikipedia.link+'" target="_blank">'+this.options.data.wikipedia.link+'</a></p>' : ''}
                            `, this.options.data.place_name, this.options.data.country.cca3, this.options.data.category.name, this.options.data.subcategory.name)})
                        }
                    }).addTo(leafletMap);
                    loader.hide();
                });
            @endif

            @if(!$hasRequest)
            const sidebar = L.DomUtil.get('sidebar');
            const container = L.DomUtil.get('addresses-lookup');

            L.DomUtil.addClass(container, 'active');
            if (L.DomUtil.hasClass(sidebar, 'collapsed')) {
                L.DomUtil.removeClass(sidebar, 'collapsed');
            }
            @endif
        });
    </script>
</div>
