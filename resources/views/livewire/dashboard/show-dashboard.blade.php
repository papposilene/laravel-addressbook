@section('title', @ucfirst(__('app.dashboard')))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('app.dashboard'))
            </span>
        </h2>
    </x-slot>

    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="create" class="fa-solid fa-plus fa-fw text-green-500"></i>
        <i data-fa-symbol="delete" class="fa-solid fa-trash fa-fw text-red-500"></i>
        <i data-fa-symbol="edit" class="fa-solid fa-pencil fa-fw text-blue-500"></i>
        <i data-fa-symbol="favorite" class="fa-solid fa-star fa-fw text-yellow-500"></i>
        <i data-fa-symbol="show" class="fa-solid fa-ellipsis fa-fw text-green-500"></i>

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

            <!-- Dashboard -->
            <div class="flex flex-row flex-wrap py-5">
                <div class="flex flex-col w-full lg:pr-1 lg:w-1/3">
                    @auth
                    <h3 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                        @ucfirst(__('app.administration'))
                    </h3>
                    <ul class="flex flex-col bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded">
                        @can('manage_categories')
                            <li class="flex w-full mb-3">
                                <a href="{{ route('admin.category.create') }}" class="inline-flex items-center w-full bg-slate-300 p-2 rounded">
                                    <svg class="h-6 w-6 mr-2">
                                        <use xlink:href="#create"></use>
                                    </svg>
                                    @ucfirst(__('category.create_one'))
                                </a>
                            </li>
                        @endcan
                        @can('manage_addresses')
                        <li class="flex w-full">
                            <a href="{{ route('admin.address.create') }}" class="inline-flex items-center w-full bg-slate-300 p-2 rounded">
                                <svg class="h-6 w-6 mr-2">
                                    <use xlink:href="#create"></use>
                                </svg>
                                @ucfirst(__('address.create_one'))
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endauth

                    <h3 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                        @ucfirst(__('app.statistics'))
                    </h3>
                    <ul class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                        <li class="flex flex-row justify-between m-1">
                            <span class="m-1 font-bold">@ucfirst(__('app.count_of', [
                                'pronoun' => __('address.pronoun_pl'),
                                'what' => __('address.addresses')
                            ]))</span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-bold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($addresses->count())
                            </span>
                        </li>
                        <li class="flex flex-row justify-between m-1">
                            <span class="m-1">@ucfirst(__('app.count_of', [
                                'pronoun' => __('category.pronoun_pl'),
                                'what' => __('category.subcategories')
                            ]))</span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($subcategories->count())
                            </span>
                        </li>
                        <li class="flex flex-row justify-between m-1">
                            <span class="m-1">@ucfirst(__('app.count_of', [
                                'pronoun' => __('category.pronoun_pl'),
                                'what' => __('category.categories')
                            ]))</span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($categories->count())
                            </span>
                        </li>
                        <li class="flex flex-row justify-between m-1">
                            <span class="m-1">@ucfirst(__('app.count_of', [
                                'pronoun' => __('country.pronoun_pl'),
                                'what' => __('country.countries')
                            ]))</span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($countries->count())
                            </span>
                        </li>
                        <li class="flex flex-row justify-between m-1">
                            <span class="m-1">@ucfirst(__('app.count_of', [
                                'pronoun' => __('country.pronoun_pl'),
                                'what' => __('country.subcontinents')
                            ]))</span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($subcontinents->count())
                            </span>
                        </li>
                        <li class="flex flex-row justify-between m-1">
                            <span class="m-1">@ucfirst(__('app.count_of', [
                                'pronoun' => __('country.pronoun_pl'),
                                'what' => __('country.continents')
                            ]))</span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($continents->count())
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col w-full lg:pl-1 lg:w-1/3">
                    <h3 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                        @ucfirst(__('app.top10_of', ['what' => __('country.countries')]))
                    </h3>
                    <div class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                        @livewire('chart.pie', [
                            'name' => 'topCountriesChart',
                            'api' => route('api.country.index', [
                                'limit' => 10,
                                'sortby' => 'has_addresses_count',
                                'orderby' => 'desc'
                            ]),
                        ])
                    </div>
                </div>

                <div class="flex flex-col w-full lg:px-1 lg:w-1/3">
                    <h3 class="bg-gray-300 dark:bg-gray-600 font-semibold text-xl p-3 rounded-t">
                        @ucfirst(__('app.top10_of', ['what' => __('category.categories')]))
                    </h3>
                    <div class="bg-gray-200 dark:bg-gray-400 p-3 mb-3 rounded-b">
                        @livewire('chart.pie', [
                            'name' => 'topCategoriesChart',
                            'api' => route('api.category.index', [
                                'limit' => 10,
                                'sortby' => 'has_addresses_count',
                                'orderby' => 'desc'
                            ]),
                        ])
                    </div>
                </div>
            </div>
            <!-- End of dashboard -->
        </div>
    </div>
</div>
