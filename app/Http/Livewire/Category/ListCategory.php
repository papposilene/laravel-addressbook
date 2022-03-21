<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListCategory extends Component
{
    use WithPagination;

    public $filter = '';
    public $page = 1;
    public $search = '';
    public Category $category;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::all();
        $subcategories = Subcategory::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('descriptions', 'like', '%'.$this->search.'%')
            ->orWhere('translations', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'asc')
            ->paginate(25);

        return view('livewire.category.list-category', [
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }
}
