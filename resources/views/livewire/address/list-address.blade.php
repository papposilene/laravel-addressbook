@section('title', @ucfirst(__('app.list_of', ['pronoun' => __('address.pronoun_pl'), 'what' => __('address.addresses')])))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('app.list_of', ['pronoun' => __('address.pronoun_pl'), 'what' => __('address.addresses')]))
            </span>
        </h2>
    </x-slot>

    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="icons" class="fa-solid fa-icons fa-fw"></i>
        <i data-fa-symbol="create" class="fa-solid fa-plus fa-fw text-green-400"></i>
        <i data-fa-symbol="delete" class="fa-solid fa-trash fa-fw text-red-400"></i>
        <i data-fa-symbol="edit" class="fa-solid fa-pencil fa-fw text-blue-400"></i>
        <i data-fa-symbol="favorite" class="fa-solid fa-star fa-fw text-yellow-400"></i>
        <i data-fa-symbol="show" class="fa-solid fa-magnifying-glass-arrow-right fa-fw text-green-600"></i>

        <div class="max-w-7xl mx-auto py-5 px-6">
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
                    @can('manage_addresses')
                    <a href="{{ route('admin.address.create') }}" class="inline-flex items-center bg-slate-200 mr-2 py-2 px-4 rounded"
                       title="@ucfirst(__('address.create_one'))">
                        <svg class="h-6 w-6">
                            <use xlink:href="#create"></use>
                        </svg>
                    </a>
                    @endcan
                    @livewire('interfaces.toggle')
                </div>
                <x-forms.input wire:model="search" type="search" class="ml-2" :placeholder="@ucfirst(__('app.search'))"/>
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
                        <th class="sm:w-1/12 text-center hidden sm:table-cell">@ucfirst(__('app.iteration'))</th>
                        <th class="w-2/12 sm:w-1/12 p-3">
                            <p class="flex flex-row items-center justify-center">
                                <i data-fa-symbol="globe" class="fa-solid fa-globe fa-fw"></i>
                                <svg class="h-5 w-5"><use xlink:href="#globe"></use></svg>
                            </p>
                        </th>
                        <th class="w-2/12 sm:w-3/12 p-3">@ucfirst(__('category.categories'))</th>
                        <th class="w-8/12 sm:w-4/12 text-center">@ucfirst(__('address.names'))</th>
                        <th class="sm:w-1/12 text-center hidden sm:table-cell">@ucfirst(__('address.status'))</th>
                        <th class="sm:w-2/12 text-center hidden sm:table-cell">@ucfirst(__('app.actions'))</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($addresses as $address)
                        <tr class="border-b border-slate-300 border-dashed h-12 w-12 p-4">
                            <td class="hidden sm:table-cell text-center text-gray-800">{{ $loop->iteration }}</td>
                            <td class="break-words text-center text-gray-800">
                                <a href="{{ route('front.address.index', ['filter' => $address->belongsToCountry->cca3]) }}">
                                    <span>{{ $address->belongsToCountry->flag }}</span>
                                    <span class="hidden sm:contents">@uppercase($address->belongsToCountry->cca3)</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('front.category.show', ['slug' => $address->belongsToSubcategory->slug]) }}"
                                   class="{{ $address->belongsToCategory->icon_style }} px-1.5 rounded">
                                    <span class="inline-flex align-middle">
                                        <i data-fa-symbol="{{ $address->belongsToSubcategory->slug }}"
                                           class="fa-solid fa-{{ $address->belongsToSubcategory->icon_image }} fa-fw"></i>
                                        <svg class="{{ $address->belongsToSubcategory->icon_style }} h-5 w-5">
                                            <use xlink:href="#{{ $address->belongsToSubcategory->slug }}"></use>
                                        </svg>&nbsp;
                                        <span class="hidden sm:contents">{{ $address->belongsToSubcategory->translations }}</span>
                                    </span>
                                </a>
                            </td>
                            <td class="break-words">
                                <a href="{{ route('front.address.show', ['uuid' => $address->uuid]) }}">
                                    {{ $address->place_name }}
                                </a>
                            </td>
                            <td class="hidden sm:table-cell">
                                <p class="flex flex-row h-12 items-center justify-center">
                                    <i data-fa-symbol="closed" class="fa-solid fa-times fa-fw text-red-400"></i>
                                    <i data-fa-symbol="open" class="fa-solid fa-check fa-fw text-green-400"></i>
                                    <svg class="h-5 w-5" aria-label="{{ ($address->place_status ? __('address.status_open') : __('address.status_close')) }}"
                                         title="{{ ($address->place_status ? __('address.status_open') : __('address.status_close')) }}">
                                        <use xlink:href="#{{ ($address->place_status ? 'open' : 'closed') }}"></use>
                                    </svg>
                                </p>
                            </td>
                            <td class="hidden sm:table-cell">
                                <p class="flex flex-row h-12 items-center justify-center">
                                    @can('manage_addresses')
                                    <a href="{{ route('front.address.show', ['uuid' => $address->uuid]) }}" class="mx-1">
                                        <svg class="h-5 w-5">
                                            <use xlink:href="#show"></use>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.address.edit', ['uuid' => $address->uuid]) }}" class="mx-1">
                                        <svg class="h-5 w-5">
                                            <use xlink:href="#edit"></use>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.address.delete', ['uuid' => $address->uuid]) }}" class="mx-1"
                                       onclick="return confirm('@ucfirst(__('address.delete_confirm'))');">
                                        <svg class="h-5 w-5">
                                            <use xlink:href="#delete"></use>
                                        </svg>
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

            @can('manage_addresses')
            <!-- Administration -->
            <div class="relative flex items-center justify-between my-2 w-full">
                <div class="flex flex-wrap">
                    <a href="{{ route('admin.address.export.addressesExcel') }}" class="inline-flex items-center bg-slate-200 py-2 px-4 rounded-l"
                       title="@ucfirst(__('app.export_', ['pronoun' => __('address.pronoun_pl'), 'what' => __('address.addresses')]))">
                        <i data-fa-symbol="exportExcel" class="fa-solid fa-file-excel fa-fw text-yellow-500"></i>
                        <svg class="h-6 w-6 mr-2">
                            <use xlink:href="#exportExcel"></use>
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('admin.address.export.addressesJson') }}" class="inline-flex items-center bg-slate-200 py-2 px-4 rounded-r"
                       title="@ucfirst(__('app.export_', ['pronoun' => __('address.pronoun_pl'), 'what' => __('address.addresses')]))">
                        <i data-fa-symbol="exportJson" class="fa-solid fa-file-code fa-fw text-yellow-500"></i>
                        <svg class="h-6 w-6 mr-2">
                            <use xlink:href="#exportJson"></use>
                        </svg>
                        JSON
                    </a>
                </div>
            </div>
            <!-- End of administration -->
            @endcan
        </div>
    </div>
</div>
