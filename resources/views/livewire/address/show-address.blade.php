@section('title', $address->place_name)

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight">
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

        <div class="flex flex-col lg:flex-row w-full lg:max-w-7xl lg:mx-auto py-5 px-6">
            <div class="flex flex-col pl-2 pr-2 w-full lg:w-3/4">
                @if ($errors->any())
                    <div class="bg-red-400 border border-red-600 mb-5 p-3 text-white font-bold rounded shadow">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="bg-slate-500 font-bold text-xl p-3 rounded-t">
                    {{ $address->place_name }}
                </h3>

                <div class="bg-slate-200 p-3 text-xl rounded-b">
                    <!-- Address -->
                    <div class="flex flex-row pt-1 px-2 mb-5">
                        <p class="text-black text-xl">@nl2br($address->description)</p>
                    </div>
                </div>

                <!-- Map -->
                <div class="flex flex-col pt-2 text-black">
                    <div class="flex flex-row pt-2">
                        <p class="flex flex-col bg-slate-400 justify-center items-center py-1 w-full rounded-t lg:rounded-tl">
                            <span class="px-1">
                                {{ $address->address_number }} {{ $address->address_street }}
                            </span>
                            <span class="px-1">
                                {{ $address->address_postcode }} {{ $address->address_city }}
                            </span>
                        </p>
                    </div>
                    @livewire('interfaces.map', [
                        'address' => $address,
                        'classes' => 'w-full',
                        'key' => $address->uuid,
                        'styles' => 'height:300px;',
                        'zoom' => 14,
                    ])
                    <div class="flex flex-col lg:flex-row pb-1 text-sm">
                        <i data-fa-symbol="applemap" class="fa-brands fa-apple fa-fw"></i>
                        <i data-fa-symbol="openstreetmap" class="fa-solid fa-map-location-dot fa-fw"></i>
                        <i data-fa-symbol="citymapper" class="fa-solid fa-signs-post fa-fw"></i>
                        <i data-fa-symbol="google" class="fa-brands fa-google fa-fw"></i>
                        <span class="flex grow bg-slate-400 text-black py-2 px-4 inline-flex items-center lg:rounded-bl">
                            @ucfirst(__('address.search_with'))
                        </span>
                        <a href="https://citymapper.com/directions?endcoord=@urlencode($address->address_lat . ',' .$address->address_lon)"
                           target="_blank"
                           class="bg-slate-400 text-black hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#citymapper"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_citymapper'))
                            </span>
                        </a>
                        <a href="https://nominatim.openstreetmap.org/ui/details.html?place_id=@urlencode($address->osm_place_id)"
                           target="_blank"
                           class="bg-slate-400 text-black hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#openstreetmap"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_osm_pid'))
                            </span>
                        </a>
                        <a href="https://www.google.com/maps?q=@urlencode($address->gmap_pluscode)" target="_blank"
                           class="bg-slate-400 text-black hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#google"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_gmaps'))
                            </span>
                        </a>
                        <a href="http://maps.apple.com/?sll=@urlencode($address->address_lat . ',' .$address->address_lon)"
                           target="_blank"
                           class="bg-slate-400 text-black hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center rounded-b lg:rounded-br">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#applemap"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_amap'))
                            </span>
                        </a>
                    </div>
                    <!-- End of map -->
                </div>

                @if($address->details['wikidata'])
                <!-- Wikipedia -->
                @livewire('interfaces.wikipedia', [
                    'address_uuid' => $address->uuid,
                    'wikidata' => $address->details['wikidata'],
                ])
                <!-- End of Wikipedia -->
                @endif
            </div>

            <div class="flex flex-col px-2 py-5 w-full lg:py-0 lg:pr-2 lg:w-1/4">
                <!-- Country and city -->
                <h4 class="bg-slate-500 text-gray-800 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('category.categories'))
                </h4>
                <ul class="bg-slate-300 text-gray-800 p-3 mb-3 rounded-b">
                    <li>
                        <a href="{{ route('front.category.index', ['filter' => $address->belongsToSubcategory->belongsToCategory->slug]) }}"
                           class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $address->belongsToSubcategory->belongsToCategory->slug }}"
                                   class="fas fa-{{ $address->belongsToSubcategory->belongsToCategory->icon_image }} fa-fw"></i>
                                <svg
                                    class="{{ $address->belongsToSubcategory->belongsToCategory->icon_style }} mt-1 h-5 w-5">
                                    <use
                                        xlink:href="#{{ $address->belongsToSubcategory->belongsToCategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $address->belongsToSubcategory->belongsToCategory->translations }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.category.show', ['slug' => $address->belongsToSubcategory->slug]) }}"
                           class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $address->belongsToSubcategory->slug }}"
                                   class="fas fa-{{ $address->belongsToSubcategory->icon_image }} fa-fw"></i>
                                <svg class="{{ $address->belongsToSubcategory->icon_style }} mt-1 h-5 w-5">
                                    <use xlink:href="#{{ $address->belongsToSubcategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $address->belongsToSubcategory->translations }}
                            </span>
                        </a>
                    </li>
                </ul>
                <!-- End of country and city -->

                <!-- Suggestions -->
                <h4 class="bg-slate-500 text-gray-800 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('address.suggestions'))
                </h4>
                <ul class="bg-slate-300 text-gray-800 p-3 rounded-b">
                    @foreach($suggestions as $suggestion)
                        <li>
                            <a href="{{ route('front.address.show', ['uuid' => $suggestion->uuid]) }}"
                               class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $suggestion->belongsToSubcategory->slug }}"
                                   class="fas fa-{{ $suggestion->belongsToSubcategory->icon_image }} fa-fw"></i>
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
