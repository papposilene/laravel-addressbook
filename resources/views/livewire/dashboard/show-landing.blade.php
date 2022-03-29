@section('title', @ucfirst(__('app.map')))

<div>
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

            <!-- Dashboard -->
            <div class="flex flex-row flex-wrap py-5">
                <div class="flex flex-col w-full">
                    <h3 class="bg-gray-600 text-gray-200 font-semibold text-xl p-3 rounded-t">
                        Pays
                    </h3>
                    <div class="flex flex-row flex-wrap">
                        @foreach($countries as $country)
                        <div class="flex grow bg-gray-500 hover:bg-gray-400 text-gray-200 hover:text-black p-2 lg:mb-3">
                            <a href="{{ route('front.map.index', ['country' => $country->cca3]) }}" class="flex flex-row justify-between m-1 w-full">
                                <span class="inline-flex align-middle mt-1">
                                    {{ $country->flag }}&nbsp;
                                    {{ $country->name_eng_common }}
                                </span>
                                <span class="bg-white text-black text-sm font-semibold h-8 inline-flex items-center p-1.5 border-1 border-black border-dotted rounded-full">
                                    @leadingzero($country->has_addresses_count)
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col w-full">
                    <h3 class="bg-gray-600 text-gray-200 font-semibold text-xl p-3 rounded-t">
                        @ucfirst(__('app.list_of', [
                            'pronoun' => __('category.pronoun_pl'),
                            'what' => __('category.categories')
                        ]))
                    </h3>
                    <div class="flex flex-row flex-wrap">
                        @foreach($categories as $category)
                        <div class="flex grow {{ $category->belongsToCategory->icon_style }} p-2">
                            <a href="{{ route('front.map.index', ['category' => $category->slug]) }}" class="flex flex-row justify-between m-1 w-full">
                                <span class="inline-flex align-middle mt-1">
                                    <i data-fa-symbol="{{ $category->slug }}" class="fas fa-{{ $category->icon_image }} fa-fw"></i>
                                    <svg class="h-5 w-5">
                                        <use xlink:href="#{{ $category->slug }}"></use>
                                    </svg>&nbsp;
                                    {{ $category->translations }}
                                </span>
                                <span class="bg-white text-black text-sm font-semibold h-8 inline-flex items-center p-1.5 border-1 border-black border-dotted rounded-full">
                                    @leadingzero($category->hasAddresses()->count())
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- End of dashboard -->
        </div>
    </div>
</div>
