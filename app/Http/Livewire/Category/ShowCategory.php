<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCategory extends Component
{
    use WithPagination;

    public string $filter = '';
    public $page = 1;
    public string $search = '';
    public string $slug;
    protected $addresses;
    protected $categories;
    protected $subcategory;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->categories = Category::all();
        $this->subcategory = Subcategory::findOrFail($this->slug);

        return view('livewire.category.show-category', [
            'categories' => $this->categories,
            'subcategory' => $this->subcategory,
            'addresses' => $this->subcategory
                ->hasAddresses()
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }
}
