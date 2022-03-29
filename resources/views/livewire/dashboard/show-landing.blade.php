@section('title', @ucfirst(__('app.map')))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('app.map'))
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
            <!--div class="relative flex items-center justify-between mb-2 w-full">
                <div class="flex flex-wrap">

                </div>
                <x-forms.input wire:model="search" type="search" class="ml-2"
                               :placeholder="@ucfirst(__('app.search'))"/>
            </div-->
            <!-- End of navigation and search -->

            <!-- Dashboard -->
            <div class="flex flex-row flex-wrap py-5">
                <div class="flex flex-col w-full lg:pr-1 lg:w-1/3">
                    <h3 class="bg-gray-600 text-gray-200 font-semibold text-xl p-3 rounded-t">
                        Pays
                    </h3>
                    <ul class="bg-gray-500 text-gray-200 p-3 mb-3 rounded-b">
                        @foreach($countries as $country)
                        <li class="flex flex-row justify-between m-1">
                            <span class="">
                                {{ $country->flag }}&nbsp;
                                {{ $country->name_eng_common }}
                            </span>
                            <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                @leadingzero($country->has_addresses_count)
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex flex-col w-full lg:pl-1 lg:w-2/3">
                    <h3 class="bg-gray-600 text-gray-200 font-semibold text-xl p-3 rounded-t">
                        @ucfirst(__('app.list_of', [
                            'pronoun' => __('category.pronoun_pl'),
                            'what' => __('category.categories')
                        ]))
                    </h3>
                    @foreach($categories->chunk(($categories->count() / 2)) as $chunk)
                    <ul class="bg-gray-500 text-gray-200 p-3 mb-3 rounded-b lg:w-1/2">
                        @foreach($chunk as $category)
                            <li class="flex flex-row m-1">
                                <a href="{{ route('front.category.index', ['filter' => $category->slug]) }}" class="flex flex-row justify-between m-1 w-full">
                                    <span class="inline-flex align-middle mt-1">
                                        <i data-fa-symbol="{{ $category->slug }}" class="fas fa-{{ $category->icon_image }} fa-fw"></i>
                                        <svg class="{{ $category->icon_style }} h-5 w-5">
                                            <use xlink:href="#{{ $category->slug }}"></use>
                                        </svg>&nbsp;
                                        {{ $category->translations }}
                                    </span>
                                    <span class="bg-blue-200 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full">
                                        @leadingzero($category->hasAddresses()->count())
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @endforeach
                </div>
            </div>
            <!-- End of dashboard -->
        </div>
    </div>
</div>
