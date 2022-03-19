@section('title', @ucfirst(__('app.list_of', ['what' => __('app.countries')])))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-bluegray-800 dark:text-bluegray-100 leading-tight">
            <span>@ucfirst(__('app.list_of', ['what' => __('app.countries')]))</span>
        </h2>
    </x-slot>

    <div>
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
                <!--x-forms.input wire:model="search" type="search" class="ml-2" :placeholder="@ucfirst(__('app.search'))" /-->
            </div>
            <!-- End of navigation and search -->

            <!-- Pagination -->
            {{ $countries->links() }}
            <!-- End of pagination -->

            <!-- Countries -->
            <div class="py-5">
                <table class="w-full p-5 table-fixed rounded shadow">
                    <thead>
                        <tr class="bg-bluegray-700 dark:bg-gray-900 text-white">
                            <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                            <th class="w-1/12 text-center p-3">@ucfirst(__('country.cca3'))</th>
                            <th class="w-1/12 text-center">@ucfirst(__('country.flag'))</th>
                            <th class="w-5/12 text-center">@ucfirst(__('country.name_formal'))</th>
                            <th class="w-1/12 text-center">@ucfirst(__('address.count'))</th>
                            <th class="w-3/12 text-center">@ucfirst(__('app.actions'))</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countries as $country)
                        <tr class="border-b border-bluegray-300 border-dashed h-12 w-12 p-4">
                            <td class="text-center hidden lg:table-cell">{{ $loop->iteration }}</td>
                            <td class="break-words">
                                {{ $country->cca3 }}
                            </td>
                            <td class="break-words">
                                {{ $country->flag }}
                            </td>
                            <td class="break-words">
                                {{ $country->name_eng_common }}
                            </td>
                            <td class="break-words">

                            </td>
                            <td class="break-words">

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
