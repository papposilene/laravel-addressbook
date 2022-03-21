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

    public Category $category;
    public $filter = '';
    public $page = 1;
    public $search = '';
    public $slug;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public function mount($slug)
    {
        $this->subcategory = Subcategory::find( $this->slug);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.category.show-category', [
            'subcategory' => $this->subcategory,
            'addresses' => $this->subcategory
                ->hasAddresses()
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }
}
