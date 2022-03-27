@section('title', $subcategory->translations)

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight">
            <span class="inline-flex align-middle text-gray-500">
                <a href="{{ route('front.category.index') }}">
                    @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')]))
                </a>&nbsp;/&nbsp;
                <a href="{{ route('front.category.index', ['filter' => $subcategory->belongsToCategory->slug]) }}" class="inline-flex align-middle">
                    <i data-fa-symbol="{{ $subcategory->belongsToCategory->slug }}" class="fas fa-{{ $subcategory->belongsToCategory->icon_image }} fa-fw"></i>
                    <svg class="{{ $subcategory->belongsToCategory->icon_style }} h-5 w-5">
                        <use xlink:href="#{{ $subcategory->belongsToCategory->slug }}"></use>
                    </svg>&nbsp;
                    {{ $subcategory->belongsToCategory->translations }}
                </a>&nbsp;/&nbsp;
            </span>
            <span class="inline-flex align-middle">
                <i data-fa-symbol="{{ $subcategory->slug }}" class="fas fa-{{ $subcategory->icon_image }} fa-fw"></i>
                <svg class="{{ $subcategory->icon_style }} h-5 w-5">
                    <use xlink:href="#{{ $subcategory->slug }}"></use>
                </svg>&nbsp;
                {{ $subcategory->translations }}
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

        <div class="flex flex-col lg:flex-row-reverse w-full lg:max-w-7xl lg:mx-auto py-5 px-6">
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

                <!-- Navigation and search -->
                <div class="relative flex items-center justify-between mb-2 w-full">
                    <div class="flex flex-wrap">
                        <button class="bg-slate-200 hover:bg-gray-200 text-black py-2 px-4 rounded inline-flex items-center">
                            <svg class="h-6 w-6"><use xlink:href="#create"></use></svg>
                        </button>
                    </div>
                    <x-forms.input wire:model="search" type="search" class="ml-2" :placeholder="@ucfirst(__('app.search'))" />
                </div>
                <!-- End of navigation and search -->

                <!-- Pagination -->
                {{ $addresses->links() }}
                <!-- End of pagination -->

                <!-- Addresses -->
                <div class="py-5">
                    <table class="bg-slate-500 p-5 table-fixed w-full rounded">
                        <thead>
                        <tr class="bg-slate-600 text-white">
                            <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                            <th class="w-2/12 text-center">@ucfirst(__('country.name_common'))</th>
                            <th class="w-6/12 text-center">@ucfirst(__('address.name'))</th>
                            <th class="w-1/12 text-center">@ucfirst(__('address.status'))</th>
                            <th class="w-2/12 text-center">@ucfirst(__('app.actions'))</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addresses as $address)
                            <tr class="border-b border-slate-300 border-dashed h-12 w-12 p-4">
                                <td class="text-center hidden lg:table-cell">{{ $loop->iteration }}</td>
                                <td class="break-words text-center">
                                    <a href="{{ route('front.country.show', ['cca3' => $address->belongsToCountry->cca3]) }}">
                                        {{ $address->belongsToCountry->flag }}
                                        @uppercase($address->belongsToCountry->cca3)
                                    </a>
                                </td>
                                <td class="break-words">
                                    <a href="{{ route('front.address.show', ['uuid' => $address->uuid]) }}">
                                        {{ $address->place_name }}
                                    </a>
                                </td>
                                <td>
                                    <p class="flex flex-row h-12 items-center justify-center">
                                        <i data-fa-symbol="closed" class="fas fa-times fa-fw text-red-500"></i>
                                        <i data-fa-symbol="open" class="fas fa-check fa-fw text-green-500"></i>
                                        <svg class="h-5 w-5"><use xlink:href="#{{ ($address->place_status ? 'open' : 'closed') }}"></use></svg>
                                    </p>
                                </td>
                                <td>
                                    <p class="flex flex-row h-12 items-center justify-center">
                                        <a href="{{ route('front.address.show', ['uuid' => $address->uuid]) }}" class="mx-1">
                                            <svg class="h-5 w-5"><use xlink:href="#show"></use></svg>
                                        </a>
                                        <a href="#" class="mx-1">
                                            <svg class="h-5 w-5"><use xlink:href="#edit"></use></svg>
                                        </a>
                                        <a href="#" class="mx-1">
                                            <svg class="h-5 w-5"><use xlink:href="#delete"></use></svg>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of addresses -->

                <!-- Pagination -->
                {{ $addresses->links() }}
                <!-- End of pagination -->
            </div>

            <div class="flex flex-col px-2 py-5 w-full lg:py-0 lg:pr-2 lg:w-1/4">
                <h3 class="bg-gray-600 text-gray-200 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')]))
                </h3>
                <ul class="bg-gray-500 text-gray-200 p-3 mb-3 rounded-b">
                    <li>
                        <a href="{{ route('front.category.index') }}" class="flex flex-row justify-between mb-2">
                            <span class="inline-flex align-middle">
                                <svg class="h-5 w-5"><use xlink:href="#icons"></use></svg>&nbsp;
                                @ucfirst(__('category.all'))
                            </span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('front.category.index', ['filter' => $category->slug]) }}" class="flex flex-row justify-between m-1">
                                <span class="inline-flex align-middle">
                                    <i data-fa-symbol="{{ $category->slug }}" class="fas fa-{{ $category->icon_image }} fa-fw"></i>
                                    <svg class="{{ $category->icon_style }} h-5 w-5">
                                        <use xlink:href="#{{ $category->slug }}"></use>
                                    </svg>&nbsp;
                                    {{ $category->translations }}
                                </span>
                                <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                    @leadingzero($category->hasSubcategories()->count())
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
