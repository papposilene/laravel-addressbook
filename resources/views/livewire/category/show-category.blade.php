@section('title', $subcategory->slug)

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-bluegray-800 dark:text-bluegray-100 leading-tight">
            <i data-fa-symbol="{{ $subcategory->slug }}" class="fas {{ $subcategory->icon_image }}"></i>
            <svg class="{{ $subcategory->icon_style }}"><use xlink:href="#{{ $catesubcategorygory->slug }}"></use></svg>
            <span>{{ $subcategory->slug }}</span>
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
            <div class="max-w-5xl mx-auto py-5 px-6">
                <ol>
                    @foreach($categories as $category)
                    <li class="flex flex-row justify-between">
                        <span class="">{{ $category->translations }}</span>
                        <span class="bg-blue-100 text-blue-800 text-sm font-semibold inline-flex items-center p-1.5 rounded-full dark:bg-blue-200 dark:text-blue-800">
                            {{ $category->hasSubcategories()->count() }}
                        </span>
                    </li>
                    @endforeach
                </ol>
            </div>
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
                {{ $addresses->links() }}
                <!-- End of pagination -->

                <!-- Addresses -->
                <div class="py-5">
                    <table class="w-full p-5 table-fixed rounded shadow">
                        <thead>
                            <tr class="bg-bluegray-700 dark:bg-gray-900 text-white">
                                <th class="w-1/12 text-center p-3 hidden lg:table-cell">@ucfirst(__('app.iteration'))</th>
                                <th class="w-1/12 text-center p-3">@ucfirst(__('country.cca3'))</th>
                                <th class="w-2/12 text-center">@ucfirst(__('city.city'))</th>
                                <th class="w-4/12 text-center">@ucfirst(__('address.name'))</th>
                                <th class="w-1/12 text-center">@ucfirst(__('address.status'))</th>
                                <th class="w-3/12 text-center">@ucfirst(__('app.actions'))</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($addresses as $address)
                            <tr class="border-b border-bluegray-300 border-dashed h-12 w-12 p-4">
                                <td class="text-center hidden lg:table-cell">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <a href="{{ route('front.country.show', ['cca3' => $address->country_cca3]) }}">{{ $address->country_cca3 }}</a>
                                </td>
                                <td class="break-words">
                                    <a href="{{ route('front.city.show', ['uuid' => $address->address_city]) }}">
                                        {{ $address->belongsToCity()->name }}
                                    </a>
                                </td>
                                <td class="break-words">{{ $address->place_name }}</td>
                                <td class="text-center">{{ $address->place_status }}</td>
                                <td class="break-words">
                                    <svg><use xlink:href="#show"></use></svg>
                                    <svg><use xlink:href="#edit"></use></svg>
                                    <svg><use xlink:href="#delete"></use></svg>
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
