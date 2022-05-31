<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Filament\Forms;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateCategory extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Subcategory $subcategory;

    public $category_slug;
    public $slug;
    public $name;
    public $icon_image;
    public $icon_color;
    public $icon_style;
    public $translations;
    public $descriptions;

    protected function getFormModel(): string
    {
        return Subcategory::class;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('category_slug')
                ->label(ucfirst(__('category.categories')))
                ->options(Category::orderBy('translations', 'asc')->pluck('translations', 'slug'))
                ->searchable()
                ->required(),
            Forms\Components\Grid::make([
                    'default' => 1,
                    'lg' => 2,
                ])->schema([
                    Forms\Components\TextInput::make('icon_image')
                        ->label(ucfirst(__('category.iconImageLabel')))
                        ->helperText(__('category.iconImageHelper'))
                        ->placeholder('icons')
                        ->default('icons'),
                    Forms\Components\TextInput::make('icon_style')
                        ->label(ucfirst(__('category.iconStyleLabel')))
                        ->helperText(__('category.iconStyleHelper'))
                        ->placeholder('bg-black text-white')
                        ->default('bg-black text-white'),
                ]),
            Forms\Components\KeyValue::make('translations')
                ->helperText(__('category.translationsHelper'))
                ->keyLabel(ucfirst(__('app.langs')))
                ->label(ucfirst(__('category.translationsLabel')))
                ->valueLabel(ucfirst(__('category.translations')))
                ->required(),
            Forms\Components\KeyValue::make('descriptions')
                ->helperText(__('category.translationsHelper'))
                ->keyLabel(ucfirst(__('app.langs')))
                ->label(ucfirst(__('category.descriptionsLabel')))
                ->valueLabel(ucfirst(__('category.translations')))
                ->required(),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        $answers = $this->form->getState();
        $name = reset($answers['translations']);

        $category = new Subcategory();
        $category->category_slug = $answers['category_slug'];
        $category->slug = Str::slug($name, '-');
        $category->name = Str::of($name)->trim();
        $category->icon_image = Str::of($answers['icon_image'])->trim();
        $category->icon_style = Str::of($answers['icon_style'])->trim();
        $category->translations = $answers['translations'];
        $category->descriptions = $answers['descriptions'];
        $category->save();

        session()->flash('message', 'Subcategory successfully created.');
        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category.create-category');
    }
}
