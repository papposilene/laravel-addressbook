@section('title', @ucfirst(__('app.list_of', ['pronoun' => __('country.pronoun_pl'), 'what' => __('country.countries')])))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-bluegray-800 dark:text-bluegray-100 leading-tight">
            <span>@ucfirst(__('app.list_of', ['pronoun' => __('country.pronoun_pl'), 'what' => __('country.countries')]))</span>
        </h2>
    </x-slot>

    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="create" class="fas fa-plus fa-fw"></i>
        <i data-fa-symbol="delete" class="fas fa-trash fa-fw"></i>
        <i data-fa-symbol="edit" class="fas fa-pencil fa-fw"></i>
        <i data-fa-symbol="favorite" class="fas fa-star fa-fw"></i>
        <i data-fa-symbol="show" class="fas fa-ellipsis fa-fw"></i>

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
            {{ $countries->links() }}
            <!-- End of pagination -->

            <!-- Countries -->
            <div class="py-5">
                <i data-fa-symbol="globe" class="fas fa-globe fa-fw"></i>
                <table class="w-full p-5 table-fixed rounded shadow">
                    <thead>
                        <tr class="bg-slate-700 dark:bg-gray-900 text-white">
                            <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                            <th class="w-1/12 text-center">
                                <svg class="h-5 w-5"><use xlink:href="#globe"></use></svg>
                            </th>
                            <th class="w-1/12 text-center p-3">@ucfirst(__('country.cca3'))</th>
                            <th class="w-1/12 text-center">@ucfirst(__('country.flag_icon'))</th>
                            <th class="w-5/12 text-center">@ucfirst(__('country.name_common'))</th>
                            <th class="w-5/12 text-center">@ucfirst(__('city.count'))</th>
                            <th class="w-1/12 text-center">@ucfirst(__('address.count'))</th>
                            <th class="w-3/12 text-center">@ucfirst(__('app.actions'))</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countries as $country)
                        <tr class="border-b border-slate-300 border-dashed h-12 w-12 p-4">
                            <td class="text-center hidden lg:table-cell">{{ $loop->iteration }}</td>
                            <td>
                                {{ $country->belongsToContinent->name }}
                            </td>
                            <td class="text-center">{{ $country->cca3 }}</td>
                            <td class="text-center">{{ $country->flag }}</td>
                            <td class="break-words">
                                <a href="{{ route('front.country.show', ['cca3' => $country->cca3]) }}">
                                    {{ $country->name_eng_common }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $country->hasCities()->count() }}
                            </td>
                            <td class="break-words">

                            </td>
                            <td class="flex flex-row h-12 items-center justify-center">
                                <a href="{{ route('front.country.show', ['cca3' => $country->cca3]) }}" class="mx-1">
                                    <svg class="h-5 w-5"><use xlink:href="#show"></use></svg>
                                </a>
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
    </div>
</div>
