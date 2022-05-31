<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListCategory extends Component
{
    use WithPagination;

    public string $filter = '';
    public $page = 1;
    public string $search = '';
    public int $withAddresses = 0;
    protected $categories;
    protected $subcategories;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
        'withAddresses' => ['except' => 0],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->categories = Category::orderBy('slug', 'asc')->get();
        $this->subcategories = Subcategory::where('category_slug', 'like', '%'.$this->filter.'%')
            ->where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('slug', 'like', '%'.$this->search.'%')
                    ->orWhere('category_slug', 'like', '%'.$this->search.'%')
                    ->orWhere('descriptions', 'like', '%'.$this->search.'%')
                    ->orWhere('translations', 'like', '%'.$this->search.'%');
            })
            ->orderBy('category_slug', 'asc')
            ->orderBy('slug', 'asc')
            ->withCount('hasAddresses')
            ->has('hasAddresses', '>=', $this->withAddresses)
            ->paginate(25);

        return view('livewire.category.list-category', [
            'categories' => $this->categories,
            'subcategories' => $this->subcategories,
        ]);
    }
}
