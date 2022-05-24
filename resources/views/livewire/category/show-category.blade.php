@section('title', $subcategory->translations)

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
            <span class="inline-flex align-middle text-gray-500">
                <a href="{{ route('front.category.index') }}">
                    @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')]))
                </a>&nbsp;/&nbsp;
                <a href="{{ route('front.category.index', ['filter' => $subcategory->belongsToCategory->slug]) }}" class="inline-flex align-middle">
                    <i data-fa-symbol="{{ $subcategory->belongsToCategory->slug }}" class="fa-solid fa-{{ $subcategory->belongsToCategory->icon_image }} fa-fw"></i>
                    <svg class="h-5 w-5">
                        <use xlink:href="#{{ $subcategory->belongsToCategory->slug }}"></use>
                    </svg>&nbsp;
                    {{ $subcategory->belongsToCategory->translations }}
                </a>&nbsp;/&nbsp;
            </span>
            <span class="inline-flex align-middle">
                <i data-fa-symbol="{{ $subcategory->slug }}" class="fa-solid fa-{{ $subcategory->icon_image }} fa-fw"></i>
                <svg class="h-5 w-5">
                    <use xlink:href="#{{ $subcategory->slug }}"></use>
                </svg>&nbsp;
                {{ $subcategory->translations }}
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
                        @can('manage_categories')
                        <a href="{{ route('admin.category.edit', ['slug' => $subcategory->slug]) }}" class="bg-slate-200 py-2 px-4 rounded inline-flex items-center mr-2">
                            <svg class="h-6 w-6">
                                <use xlink:href="#edit"></use>
                            </svg>
                        </a>
                        @endcan
                        @can('manage_addresses')
                        <a href="{{ route('admin.address.create', ['category' => $subcategory->slug]) }}" class="bg-slate-200 py-2 px-4 rounded inline-flex items-center">
                            <svg class="h-6 w-6">
                                <use xlink:href="#create"></use>
                            </svg>
                        </a>
                        @endcan
                        @livewire('interfaces.toggle')
                    </div>
                    <x-forms.input wire:model="search" type="search" class="ml-2" :placeholder="@ucfirst(__('app.search'))" />
                </div>
                <!-- End of navigation and search -->

                <!-- Pagination -->
                {{ $addresses->links() }}
                <!-- End of pagination -->

                <!-- Addresses -->
                <div class="py-5">
                    <table class="bg-slate-200 dark:bg-slate-500 p-5 table-fixed w-full rounded">
                        <thead>
                        <tr class="bg-slate-400 dark:bg-slate-600">
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
                                <td class="text-center hidden lg:table-cell text-gray-800">{{ $loop->iteration }}</td>
                                <td class="break-words text-center text-gray-800">
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
                                        <i data-fa-symbol="closed" class="fa-solid fa-times fa-fw text-red-500"></i>
                                        <i data-fa-symbol="open" class="fa-solid fa-check fa-fw text-green-500"></i>
                                        <svg class="h-5 w-5"><use xlink:href="#{{ ($address->place_status ? 'open' : 'closed') }}"></use></svg>
                                    </p>
                                </td>
                                <td>
                                    <p class="flex flex-row h-12 items-center justify-center">
                                        @can('manage_categories')
                                        <a href="{{ route('front.address.show', ['uuid' => $address->uuid]) }}" class="mx-1">
                                            <svg class="h-5 w-5"><use xlink:href="#show"></use></svg>
                                        </a>
                                        <a href="#" class="mx-1">
                                            <svg class="h-5 w-5"><use xlink:href="#edit"></use></svg>
                                        </a>
                                        <a href="#" class="mx-1">
                                            <svg class="h-5 w-5"><use xlink:href="#delete"></use></svg>
                                        </a>
                                        @else
                                        <span class="mx-1">
                                            ---
                                        </span>
                                        @endcan
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
                <h3 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')]))
                </h3>
                <ul class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                    <li class="bg-black text-white rounded">
                        <a href="{{ route('front.category.index') }}" class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle m-1">
                                <svg class="h-5 w-5"><use xlink:href="#icons"></use></svg>&nbsp;
                                @ucfirst(__('category.all'))
                            </span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li class="{{ $category->icon_style }} rounded">
                        <a href="{{ route('front.category.index', ['filter' => $category->slug]) }}" class="flex flex-row justify-between m-1">
                            <span class="inline-flex align-middle mt-1">
                                <i data-fa-symbol="{{ $category->slug }}" class="fa-solid fa-{{ $category->icon_image }} fa-fw"></i>
                                <svg class="{{ $category->icon_style }} h-5 w-5">
                                    <use xlink:href="#{{ $category->slug }}"></use>
                                </svg>&nbsp;
                                {{ $category->translations }}
                            </span>
                            <span class="bg-white text-black text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
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
