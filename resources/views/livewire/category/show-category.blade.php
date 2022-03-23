@section('title', $subcategory->slug)

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-100 leading-tight">
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

        <div class="flex flex-row max-w-7xl mx-auto py-5 px-6">
            <div class="flex flex-col pr-2 w-1/4">
                <h3 class="bg-slate-300 p-3 text-xl rounded-t">
                    @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')]))
                </h3>
                <ol class="bg-slate-200 p-3 rounded-b">
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
                                <span class="bg-blue-100 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full dark:bg-blue-200 dark:text-blue-800">
                                {{ $category->hasSubcategories()->count() }}
                            </span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="flex flex-col pl-2 w-3/4">
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
                    <table class="w-full p-5 table-fixed rounded shadow">
                        <thead>
                        <tr class="bg-slate-700 dark:bg-gray-900 text-white">
                            <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                            <th class="w-1/12 text-center p-3">
                                <svg class="h-5 w-5"><use xlink:href="#icons"></use></svg>
                            </th>
                            <th class="w-3/12 text-center">@ucfirst(__('category.categories'))</th>
                            <th class="w-4/12 text-center">@ucfirst(__('category.name'))</th>
                            <th class="w-1/12 text-center">@ucfirst(__('address.count'))</th>
                            <th class="w-2/12 text-center">@ucfirst(__('app.actions'))</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addresses as $address)
                            <tr class="border-b border-slate-300 border-dashed h-12 w-12 p-4">
                                <td class="text-center hidden lg:table-cell">{{ $loop->iteration }}</td>
                                <td class="flex flex-row h-12 items-center justify-center">
                                    <i data-fa-symbol="{{ $subcategory->slug }}" class="fas fa-{{ $subcategory->icon_image }} fa-fw"></i>
                                    <svg class="{{ $subcategory->icon_style }} h-5 w-5"><use xlink:href="#{{ $subcategory->slug }}"></use></svg>
                                </td>
                                <td class="break-words">
                                    {{ $subcategory->belongsToCategory->translations }}
                                </td>
                                <td class="break-words">
                                    <a href="{{ route('front.category.show', ['slug' => $subcategory->slug]) }}">
                                        {{ $subcategory->translations }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $subcategory->has_addresses_count }}
                                </td>
                                <td class="flex flex-row h-12 items-center justify-center">
                                    <a href="{{ route('front.address.show', ['uuid' => $address->uuid]) }}" class="mx-1">
                                        <svg class="h-5 w-5"><use xlink:href="#show"></use></svg>
                                    </a>
                                    <a href="#" class="mx-1">
                                        <svg class="h-5 w-5"><use xlink:href="#edit"></use></svg>
                                    </a>
                                    <a href="#" class="mx-1">
                                        <svg class="h-5 w-5"><use xlink:href="#delete"></use></svg>
                                    </a>
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
        </div>
    </div>
</div>
