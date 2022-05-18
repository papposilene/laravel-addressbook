<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Filament\Forms;
use Livewire\Component;

class CreateCategory extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Subcategory $subcategory;

    public $category_slug;
    public $slug;
    public $name;
    public $icon_image;
    public $icon_options;
    public $translations;
    public $descriptions;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('category_slug')
                ->label(ucfirst(__('category.categories')))
                ->options(Category::orderBy('slug', 'asc')->pluck('name', 'slug'))
                ->searchable(),
            Forms\Components\TextInput::make('name')
                ->label(ucfirst(__('category.name')))
                ->required(),
            Forms\Components\TextInput::make('icon_image')
                ->label(ucfirst(__('category.iconImageLabel')))
                ->helperText(__('category.iconImageHelper'))
                ->default('fas fa-icons fa-fw'),
            Forms\Components\TextInput::make('icon_options')
                ->label(ucfirst(__('category.iconOptionsLabel')))
                ->helperText(__('category.iconOptionsHelper'))
                ->default('bg-black text-white'),
            Forms\Components\Textarea::make('description')
                ->label(ucfirst(__('category.description')))
                ->required(),
        ];
    }

    public function submit(): void
    {
        // ...
    }

    public function render()
    {
        return view('livewire.category.create-category');
    }
}
