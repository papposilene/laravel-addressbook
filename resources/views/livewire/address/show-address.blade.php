@section('title', $address->place_name)

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
            <span class="inline-flex align-middle text-gray-500">
                <a href="{{ route('front.address.index') }}">
                    @ucfirst(__('app.list_of', ['pronoun' => __('address.pronoun_pl'), 'what' => __('address.addresses')]))
                </a>&nbsp;/&nbsp;
            </span>
            <span class="inline-flex align-middle">
                {{ $address->place_name }}
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
        <i data-fa-symbol="show" class="fas fa-ellipsis fa-fw text-green-500"></i>

        <div class="flex flex-row max-w-7xl mx-auto py-5 px-6">
            <div class="flex flex-col pl-2 pr-2 w-3/4">
                @if ($errors->any())
                    <div class="bg-red-400 border border-red-600 mb-5 p-3 text-white font-bold rounded shadow">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="bg-slate-300 p-3 text-xl rounded-t">
                    {{ $address->place_name }}
                </h3>

                <!-- Address -->
                <div class="bg-slate-200 p-3 text-xl rounded-b">
                    <div class="pb-5">
                        <p>@nl2br($address->description)</p>
                    </div>

                    <div class="flex flex-row w-full">
                        <a href="{{ route('front.country.show', ['cca3' => $address->belongsToCountry->cca3]) }}">
                            {{ $address->belongsToCountry->name_eng_common }}
                        </a>&nbsp;/
                        @if($address->belongsToCity)
                        {{ $address->belongsToCity->state }} /
                        <a href="{{ route('front.city.show', ['cca3' => $address->country_cca3, 'uuid' => $address->belongsToCity->uuid]) }}">
                            {{ $address->belongsToCity->name }}
                        </a>
                        @else
                        {{ $address->address_city }}
                        @endif
                    </div>


                    <div class="flex flex-row py-3">
                        <span class="flex grow-0 bg-slate-300 text-black py-2 px-4 inline-flex items-center rounded-l">
                            @ucfirst(__('category.category'))
                        </span>
                        <a href="{{ route('front.category.index', ['filter' => $address->belongsToSubcategory->belongsToCategory->slug]) }}"
                           class="flex grow bg-slate-300 hover:bg-slate-400 text-black py-2 px-4 inline-flex">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $address->belongsToSubcategory->belongsToCategory->slug }}"
                                   class="fas fa-{{ $address->belongsToSubcategory->belongsToCategory->icon_image }} fa-fw"></i>
                                <svg class="{{ $address->belongsToSubcategory->belongsToCategory->icon_style }} mt-1 h-5 w-5">
                                    <use xlink:href="#{{ $address->belongsToSubcategory->belongsToCategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $address->belongsToSubcategory->belongsToCategory->translations }}
                            </span>
                        </a>
                        <span class="flex grow-0 bg-slate-300 text-black py-2 px-4 inline-flex items-center">
                            @ucfirst(__('category.subcategory'))
                        </span>
                        <a href="{{ route('front.category.show', ['slug' => $address->belongsToSubcategory->slug]) }}"
                           class="flex grow bg-slate-300 hover:bg-slate-400 text-black py-2 px-4 inline-flex rounded-r">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $address->belongsToSubcategory->slug }}"
                                   class="fas fa-{{ $address->belongsToSubcategory->icon_image }} fa-fw"></i>
                                <svg class="{{ $address->belongsToSubcategory->icon_style }} mt-1 h-5 w-5">
                                    <use xlink:href="#{{ $address->belongsToSubcategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $address->belongsToSubcategory->translations }}
                            </span>
                        </a>
                    </div>
                    <div class="flex flex-row py-3">
                        <p class="flex w-full lg:w-1/2 bg-red-400">
                            {{ $address->address_number }} {{ $address->address_street }}<br />
                            {{ $address->address_postcode }} {{ $address->address_city }}<br />
                            <a href="{{ route('front.country.show', ['cca3' => $address->belongsToCountry->cca3]) }}">
                                {{ $address->belongsToCountry->flag }} {{ $address->belongsToCountry->name_eng_common }}
                            </a>
                        </p>
                        <p class="flex w-full lg:w-1/2 bg-blue-400">
                            {{ $address->address_lat }},{{ $address->address_lon }}<br />
                        </p>
                    </div>

                    @livewire('interfaces.map', [
                        'address' => $address,
                        'classes' => 'h-64 w-full rounded-t',
                        'styles' => 'height:300px;',
                        'key' => $address->uuid,
                    ])

                    <div class="flex flex-row pb-3">
                        <i data-fa-symbol="openstreetmap" class="fa-solid fa-map-location-dot fa-fw"></i>
                        <i data-fa-symbol="citymapper" class="fa-solid fa-signs-post fa-fw"></i>
                        <i data-fa-symbol="google" class="fa-brands fa-google fa-fw"></i>
                        <span class="flex grow bg-slate-300 text-black py-2 px-4 inline-flex items-center rounded-bl">
                            @ucfirst(__('address.search_with'))
                        </span>
                        <a href="https://nominatim.openstreetmap.org/ui/details.html?place_id=@urlencode($address->osm_place_id)" target="_blank"
                           class="bg-slate-300 hover:bg-slate-400 text-black py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-5 w-5">
                                    <use xlink:href="#openstreetmap"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_osm_pid'))
                            </span>
                        </a>
                        <a href="https://citymapper.com/directions?endcoord=@urlencode($address->address_lat . ',' .$address->address_lon)" target="_blank"
                           class="bg-slate-300 hover:bg-slate-400 text-black py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-5 w-5">
                                    <use xlink:href="#citymapper"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_citymapper'))
                            </span>
                        </a>
                        <a href="https://www.google.com/maps?q=@urlencode($address->gmap_pluscode)" target="_blank"
                           class="bg-slate-300 hover:bg-slate-400 text-black py-2 px-4 inline-flex items-center rounded-br">
                            <span class="inline-flex">
                                <svg class="mt-1 h-5 w-5">
                                    <use xlink:href="#google"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_gmaps'))
                            </span>
                        </a>
                    </div>
                </div>
                <!-- End of address -->
            </div>
            <div class="flex flex-col pr-2 w-1/4">
                <h4 class="bg-slate-300 p-3 text-xl rounded-t">
                    @ucfirst(__('address.suggesions'))
                </h4>
                <ul class="bg-slate-200 p-3 rounded-b">
                    @foreach($suggestions as $suggestion)
                    <li>
                        <a href="{{ route('front.address.show', ['uuid' => $suggestion->uuid]) }}" class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $suggestion->belongsToSubcategory->slug }}" class="fas fa-{{ $suggestion->belongsToSubcategory->icon_image }} fa-fw"></i>
                                <svg class="{{ $suggestion->belongsToSubcategory->icon_style }} h-5 w-5">
                                    <use xlink:href="#{{ $suggestion->belongsToSubcategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $suggestion->place_name }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
