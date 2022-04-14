<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CategoryCollection
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', null);
        $sort = $request->get('sortby', 'slug');
        $order = $request->get('orderby', 'asc');

        if($limit) {
            $categories = Category::withCount('hasAddresses')
                ->orderBy($sort, $order)
                ->limit($limit)
                ->get();
        } else {
            $categories = Category::withCount('hasAddresses')
                ->orderBy($sort, $order)
                ->paginate(25);
        }

        return new CategoryCollection($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return CategoryResource
     */
    public function show(string $slug)
    {
        $category = Category::findOrFail($slug);

        return new CategoryResource($category);
    }

}
