@section('title', @ucfirst(__($country->name_eng_common)))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-bluegray-800 dark:text-bluegray-100 leading-tight">
            <span class="inline-flex align-middle text-gray-500">
                <a href="{{ route('front.country.index') }}">
                    {{ $country->belongsToContinent->name }}
                </a>&nbsp;/&nbsp;
                <a href="{{ route('front.country.index', ['filter' => $country->belongsToSubcontinent->slug]) }}">
                    {{ $country->belongsToSubcontinent->name }}
                </a>&nbsp;/&nbsp;
            </span>
            <span class="inline-flex align-middle">
                {{ $country->flag }}&nbsp;
                {{ $country->name_translations['common'] }}
            </span>
        </h2>
    </x-slot>

    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="create" class="fas fa-plus fa-fw text-green-500"></i>
        <i data-fa-symbol="delete" class="fas fa-trash fa-fw text-red-500"></i>
        <i data-fa-symbol="edit" class="fas fa-pencil fa-fw text-blue-500"></i>
        <i data-fa-symbol="favorite" class="fas fa-star fa-fw text-yellow-500"></i>
        <i data-fa-symbol="show" class="fas fa-ellipsis fa-fw text-green-500"></i>

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

                </div>
                <x-forms.input wire:model="search" type="search" class="ml-2" :placeholder="@ucfirst(__('app.search'))" />
            </div>
            <!-- End of navigation and search -->

            <!-- Pagination -->
            {{ $cities->links() }}
            <!-- End of pagination -->

            <!-- Cities -->
            <div class="py-5">
                <table class="bg-slate-200 dark:bg-slate-500 p-5 table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-400 dark:bg-slate-600">
                            <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                            <th class="w-2/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('country.states'))</th>
                            <th class="w-2/12 text-center p-3">@ucfirst(__('city.cities'))</th>
                            <th class="w-1/12 text-center p-3">@ucfirst(__('address.addresses'))</th>
                            <th class="w-2/12 text-center p-3">@ucfirst(__('app.actions'))</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $city)
                        <tr class="border-b border-slate-300 border-dashed h-12 w-12 p-4">
                            <td class="text-center hidden lg:table-cell text-gray-800">{{ $loop->iteration }}</td>
                            <td class="hidden lg:table-cell text-gray-800">{{ ($city->belongsToRegion ? $city->belongsToRegion->name_translations : '---') }}</td>
                            <td class="break-words p-3">
                                {{ $city->name_local }}
                            </td>
                            <td class="text-center text-gray-800 p-3">
                                {{ $city->has_addresses_count }}
                            </td>
                            <td>
                                <p class="flex flex-row h-12 items-center justify-center">
                                    <a href="#" class="mx-1">
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
            <!-- End of cities -->

            <!-- Pagination -->
            {{ $cities->links() }}
            <!-- End of pagination -->
        </div>
    </div>
</div>
