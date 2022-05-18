@section('title', @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')])))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-bluegray-800 dark:text-bluegray-100 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('app.list_of', ['pronoun' => __('category.pronoun_pl'), 'what' => __('category.categories')]))
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

        <div class="flex flex-col lg:flex-row-reverse w-full lg:max-w-7xl lg:mx-auto py-5 px-6">
            <div class="flex flex-col pl-2 pr-2 w-full lg:mx-auto lg:w-2/4">
                @if ($errors->any())
                <div class="bg-red-400 border border-red-600 mb-5 p-3 text-white font-bold rounded shadow">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Subcategories -->
                <div class="py-5">
                    <form wire:submit.prevent="submit">
                        {{ $this->form }}

                        <button type="submit">
                            Submit
                        </button>
                    </form>
                </div>
                <!-- End of subcategories -->
            </div>
        </div>
    </div>
</div>
