@section('title', @ucfirst(__('app.list_of', ['pronoun' => __('country.pronoun_pl'), 'what' => __('country.countries')])))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('app.list_of', ['pronoun' => __('country.pronoun_pl'), 'what' => __('country.countries')]))
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

                    </div>
                    <x-forms.input wire:model="search" type="search" class="ml-2" :placeholder="@ucfirst(__('app.search'))"/>
                </div>
                <!-- End of navigation and search -->

                <!-- Pagination -->
                {{ $countries->links() }}
                <!-- End of pagination -->

                <!-- Countries -->
                <div class="py-5">
                    <table class="bg-slate-200 dark:bg-slate-500 p-5 table-fixed w-full rounded">
                        <thead>
                        <tr class="bg-slate-400 dark:bg-slate-600">
                            <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                            <th class="w-1/12 p-3 hidden lg:table-cell">
                                <p class="flex flex-row items-center justify-center p-3">
                                    <i data-fa-symbol="globe" class="fas fa-globe fa-fw"></i>
                                    <svg class="h-5 w-5">
                                        <use xlink:href="#globe"></use>
                                    </svg>
                                </p>
                            </th>
                            <th class="w-1/12 p-3 hidden lg:table-cell text-center">@ucfirst(__('country.flag_icon'))
                            </th>
                            <th class="w-7/12 p-3 text-center">@ucfirst(__('country.name_common'))</th>
                            <th class="w-2/12 p-3 text-center">@ucfirst(__('address.addresses'))</th>
                            <th class="w-2/12 p-3 text-center">@ucfirst(__('app.actions'))</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($countries as $country)
                            <tr class="border-b border-slate-300 border-dashed h-12 w-12 p-4">
                                <td class="hidden lg:table-cell text-center text-gray-800">{{ $loop->iteration }}</td>
                                <td class="hidden lg:table-cell text-gray-800">
                                    {{ $country->belongsToContinent->name }}
                                </td>
                                <td class="hidden lg:table-cell text-center">{{ $country->flag }}</td>
                                <td class="break-words p-3">
                                    <a href="{{ route('front.address.index', ['filter' => $country->cca3]) }}">
                                        {{ $country->name_eng_common }}
                                    </a>
                                </td>
                                <td class="text-center text-gray-800">
                                    {{ $country->hasCities()->count() }}
                                </td>
                                <td class="text-center text-gray-800">
                                    {{ $country->has_addresses_count }}
                                </td>
                                <td>
                                    <p class="flex flex-row h-12 items-center justify-center">
                                        <a href="{{ route('front.address.index', ['filter' => $country->cca3]) }}"
                                           class="mx-1">
                                            <svg class="h-5 w-5">
                                                <use xlink:href="#show"></use>
                                            </svg>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End of countries -->

                <!-- Pagination -->
                {{ $countries->links() }}
                <!-- End of pagination -->
            </div>

            <div class="flex flex-col px-2 py-5 w-full lg:py-0 lg:pr-2 lg:w-1/4">
                <h3 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                    @ucfirst(__('app.list_of', ['pronoun' => __('country.pronoun_pl'), 'what' =>
                    __('country.subcontinents')]))
                </h3>
                <ul class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                    <li>
                        <a href="{{ route('front.country.index') }}" class="flex flex-row justify-between mb-2">
                            <span class="mb-1.5">@ucfirst(__('country.all_subcontinents'))</span>
                        </a>
                    </li>
                    @foreach($subcontinents as $subcontinent)
                        <li>
                            <a href="{{ route('front.country.index', ['filter' => $subcontinent->slug]) }}"
                               class="flex flex-row justify-between m-1">
                                <span class="">{{ $subcontinent->name }}</span>
                                <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                    @leadingzero($subcontinent->hasCountries()->count())
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
