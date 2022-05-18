<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Filament\Forms;
use Illuminate\Support\Str;
use Livewire\Component;

class EditCategory extends Component implements Forms\Contracts\HasForms
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

    public function mount(string $slug): void
    {
        $this->subcategory = Subcategory::where('slug', $slug)->firstOrFail();

        $translations = $this->subcategory->getTranslations();

        $this->form->fill([
            'uuid' => $this->subcategory->uuid,
            'slug' => $this->subcategory->slug,
            'category_slug' => $this->subcategory->category_slug,
            'icon_image' => $this->subcategory->icon_image,
            'icon_style' => $this->subcategory->icon_style,
            'icon_color' => $this->subcategory->icon_color,
            'translations' => $translations['translations'],
            'descriptions' => $translations['descriptions'],
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Hidden::make('uuid'),
            Forms\Components\Hidden::make('slug'),
            Forms\Components\Select::make('category_slug')
                ->label(ucfirst(__('category.categories')))
                ->options(Category::orderBy('slug', 'asc')->pluck('name', 'slug'))
                //->searchable() // if uncommented, the selected attribute will not work
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

        $category = Subcategory::findOrFail($answers['slug']);
        $category->category_slug = $answers['category_slug'];
        $category->slug = Str::slug($name, '-');
        $category->name = $name;
        $category->icon_image = $answers['icon_image'];
        $category->icon_style = $answers['icon_style'];
        $category->translations = $answers['translations'];
        $category->descriptions = $answers['descriptions'];
        $category->save();

        session()->flash('message', 'Subcategory successfully updated.');
        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category.edit-category');
    }
}
