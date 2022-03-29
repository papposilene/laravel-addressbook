@section('title', @ucfirst(__('app.create_', ['pronoun' => __('address.pronoun_sg'), 'what' => __('address.address')])))

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-300 leading-tight">
            <span class="inline-flex align-middle">
                @ucfirst(__('app.list_of', ['pronoun' => __('address.pronoun_pl'), 'what' => __('address.addresses')]))
            </span>
        </h2>
    </x-slot>

    <div>
        <!-- @see https://fontawesome.com/docs/web/add-icons/svg-symbols -->
        <i data-fa-symbol="icons" class="fas fa-icons fa-fw"></i>
        <i data-fa-symbol="create" class="fas fa-plus fa-fw text-green-400"></i>
        <i data-fa-symbol="delete" class="fas fa-trash fa-fw text-red-400"></i>
        <i data-fa-symbol="edit" class="fas fa-pencil fa-fw text-blue-400"></i>
        <i data-fa-symbol="favorite" class="fas fa-star fa-fw text-yellow-400"></i>
        <i data-fa-symbol="show" class="fas fa-ellipsis fa-fw text-green-400"></i>

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
        </div>
    </div>
</div>
