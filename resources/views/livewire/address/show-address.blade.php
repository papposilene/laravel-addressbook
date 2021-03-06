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
        <i data-fa-symbol="icons" class="fa-solid fa-icons fa-fw"></i>
        <i data-fa-symbol="create" class="fa-solid fa-plus fa-fw text-green-500"></i>
        <i data-fa-symbol="delete" class="fa-solid fa-trash fa-fw text-red-500"></i>
        <i data-fa-symbol="edit" class="fa-solid fa-pencil fa-fw text-blue-500"></i>
        <i data-fa-symbol="favorite" class="fa-solid fa-star fa-fw text-yellow-500"></i>
        <i data-fa-symbol="show" class="fa-solid fa-magnifying-glass-arrow-right fa-fw text-green-600"></i>

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

                <h3 class="p-3 bg-slate-300 dark:bg-slate-500 font-bold text-xl rounded-t">
                    {{ $address->place_name }}
                    <i data-fa-symbol="closed" class="fa-solid fa-times fa-fw text-red-600"></i>
                    <i data-fa-symbol="open" class="fa-solid fa-check fa-fw text-green-600"></i>
                    <span class="float-right inline-flex items-center p-1.5 rounded-full {{ ($address->place_status ? 'bg-green-200' : 'bg-red-200') }} text-sm font-bold">
                        <svg class="h-5 w-5" aria-label="{{ ($address->place_status ? __('address.status_open') : __('address.status_close')) }}"
                             title="{{ ($address->place_status ? __('address.status_open') : __('address.status_close')) }}">
                            <use xlink:href="#{{ ($address->place_status ? 'open' : 'closed') }}"></use>
                        </svg>
                    </span>
                </h3>

                <!-- Address -->
                <div class="flex flex-col bg-slate-200 p-3 text-xl rounded-b">
                    <div class="flex flex-row pt-1 px-2 mb-5">
                        @if($address->description)
                        <p class="text-black text-xl">
                            @nl2br($address->description)
                        </p>
                        @else
                        <p class="text-black text-base italic">
                            @ucfirst(__('address.no_description'))
                        </p>
                        @endif
                    </div>
                </div>
                <!-- End of address -->


                <!-- Contact details -->
                <div class="flex flex-col lg:flex-row pt-2 mt-2 pb-1">
                    <div class="grow-0 bg-slate-200 dark:bg-slate-400 py-2 px-4 inline-flex items-center rounded-l">
                        &nbsp;
                    </div>
                    @if($address->details['phone'])
                    <div class="grow-0 bg-slate-200 dark:bg-slate-400 text-black hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                        <a href="tel:{{ $address->details['phone'] }}" class=" hover:text-white">
                            <i class="fa-solid fa-phone"></i>&nbsp;
                            {{ $address->details['phone'] }}
                        </a>
                    </div>
                    @else
                    <div class="grow-0 bg-slate-200 dark:bg-slate-400 text-black hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                        @ucfirst(__('address.no_phone'))
                    </div>
                    @endif
                    @if($address->details['website'])
                    <div class="grow-0 bg-slate-200 dark:bg-slate-400 text-black py-2 px-4 inline-flex items-center">
                        <a href="{{ $address->details['website'] }}" class=" hover:text-white" target="_blank">
                            <i class="fa-solid fa-link"></i>&nbsp;
                            @urlhost($address->details['website'])
                        </a>
                    </div>
                    @else
                    <div class="grow-0 bg-slate-200 dark:bg-slate-400 text-black py-2 px-4 inline-flex items-center">
                        @ucfirst(__('address.no_website'))
                    </div>
                    @endif
                    <div class="grow bg-slate-200 dark:bg-slate-400 py-2 px-4 hidden sm:inline-flex sm:items-center">
                        &nbsp;
                    </div>
                    <div class="grow-0 bg-slate-200 dark:bg-slate-400 py-2 px-4 inline-flex items-center rounded-r">
                        &nbsp;
                    </div>
                </div>
                <!-- End of contact details -->

                <!-- Map -->
                <div class="flex flex-col pt-2 text-black">
                    <div class="flex flex-row pt-2">
                        <h4 class="flex flex-col bg-slate-200 dark:bg-slate-400 justify-center items-center py-1 text-lg w-full rounded-t lg:rounded-tl">
                            <span class="px-1">
                                {{ $address->address_number }} {{ $address->address_street }}
                            </span>
                            <span class="px-1">
                                {{ $address->address_postcode }} {{ $address->address_city }}
                            </span>
                        </h4>
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
                        <span
                            class="flex grow bg-slate-200 dark:bg-slate-400 text-black py-2 px-4 inline-flex items-center lg:rounded-bl">
                            @ucfirst(__('address.search_with'))
                        </span>
                        <a href="https://citymapper.com/directions?endcoord=@urlencode($address->address_lat . ',' .$address->address_lon)"
                           target="_blank"
                           class="bg-slate-200 dark:bg-slate-400  hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#citymapper"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_citymapper'))
                            </span>
                        </a>
                        <a href="https://nominatim.openstreetmap.org/ui/details.html?place_id=@urlencode($address->osm_place_id)"
                           target="_blank"
                           class="bg-slate-200 dark:bg-slate-400  hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#openstreetmap"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_osm'))
                            </span>
                        </a>
                        <a href="https://www.google.com/maps?q=@urlencode($address->gmap_pluscode)" target="_blank"
                           class="bg-slate-200 dark:bg-slate-400  hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center">
                            <span class="inline-flex">
                                <svg class="mt-1 h-4 w-4">
                                    <use xlink:href="#google"></use>
                                </svg>&nbsp;
                                @ucfirst(__('address.search_with_gmaps'))
                            </span>
                        </a>
                        <a href="http://maps.apple.com/?sll=@urlencode($address->address_lat . ',' .$address->address_lon)"
                           target="_blank"
                           class="bg-slate-200 dark:bg-slate-400  hover:bg-gray-800 hover:text-white py-2 px-4 inline-flex items-center rounded-b lg:rounded-br">
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
                <h5 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('category.categories'))
                </h5>
                <ul class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                    <li>
                        <a href="{{ route('front.category.index', ['filter' => $address->belongsToCategory->slug]) }}"
                           class="flex flex-row justify-between {{ $address->belongsToCategory->icon_style }} mb-2 px-1.5 rounded">
                            <span class="inline-flex align-middle mt-1">
                                <i data-fa-symbol="{{ $address->belongsToCategory->slug }}"
                                   class="fa-solid fa-{{ $address->belongsToCategory->icon_image }} fa-fw"></i>
                                <svg class="h-5 w-5">
                                    <use xlink:href="#{{ $address->belongsToCategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $address->belongsToCategory->translations }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.category.show', ['slug' => $address->belongsToSubcategory->slug]) }}"
                           class="flex flex-row justify-between {{ $address->belongsToCategory->icon_style }} px-1.5 rounded">
                            <span class="inline-flex align-middle mt-1">
                                <i data-fa-symbol="{{ $address->belongsToSubcategory->slug }}"
                                   class="fa-solid fa-{{ $address->belongsToSubcategory->icon_image }} fa-fw"></i>
                                <svg class="h-5 w-5">
                                    <use xlink:href="#{{ $address->belongsToSubcategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $address->belongsToSubcategory->translations }}
                            </span>
                        </a>
                    </li>
                </ul>
                <!-- End of country and city -->

                <!-- Suggestions -->
                <h5 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('address.suggestions'))
                </h5>
                <ul class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                    @foreach($suggestions as $suggestion)
                        <li>
                            <a href="{{ route('front.address.show', ['uuid' => $suggestion->uuid]) }}"
                               class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle">
                                <i data-fa-symbol="{{ $suggestion->belongsToSubcategory->slug }}"
                                   class="fa-solid fa-{{ $suggestion->belongsToSubcategory->icon_image }} fa-fw"></i>
                                <svg class="{{ $suggestion->belongsToSubcategory->icon_style }} h-5 w-5">
                                    <use xlink:href="#{{ $suggestion->belongsToSubcategory->slug }}"></use>
                                </svg>&nbsp;
                                {{ $suggestion->place_name }}
                            </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <!-- End of suggestions -->

                @can('manage_addresses')
                <!-- Administration -->
                <h5 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('app.administration'))
                </h5>
                <ul class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                    <li class="flex w-full mb-3">
                        <a href="{{ route('admin.address.edit', ['uuid' => $address->uuid]) }}" class="inline-flex items-center w-full bg-slate-300 p-2 rounded"
                           title="@ucfirst(__('address.edit_one'))">
                            <svg class="h-6 w-6 mr-2">
                                <use xlink:href="#edit"></use>
                            </svg>
                            @ucfirst(__('address.edit_one'))
                        </a>
                    </li>
                    <li class="flex w-full">
                        <a href="{{ route('admin.address.delete', ['uuid' => $address->uuid]) }}" class="inline-flex items-center w-full bg-slate-300 p-2 rounded"
                           title="@ucfirst(__('address.delete_one'))" onclick="return confirm('@ucfirst(__('address.delete_confirm'))');">
                            <svg class="h-6 w-6 mr-2">
                                <use xlink:href="#delete"></use>
                            </svg>
                            @ucfirst(__('address.delete_one'))
                        </a>
                    </li>
                </ul>
                <!-- End of administration -->
                @endcan
            </div>
        </div>
    </div>
</div>
