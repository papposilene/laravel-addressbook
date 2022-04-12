<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubcategoryCollection;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return SubcategoryCollection
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', null);
        $sort = $request->get('sortby', 'slug');
        $order = $request->get('orderby', 'asc');

        if($limit) {
            $subcategories = Subcategory::withCount('hasAddresses')
                ->orderBy($sort, $order)
                ->limit($limit)
                ->get();
        } else {
            $subcategories = Subcategory::withCount('hasAddresses')
                ->orderBy($sort, $order)
                ->limit($limit)
                ->paginate(25);
        }

        return new SubcategoryCollection($subcategories);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return SubcategoryResource
     */
    public function show(string $slug)
    {
        $subcategory = Subcategory::where('slug', $slug)
            ->with('hasAddresses')
            ->firstOrFail();

        return new SubcategoryResource($subcategory);
    }

}
