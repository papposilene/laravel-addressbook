<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CountryCollection
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', null);
        $sort = $request->get('sortby', 'cca3');
        $order = $request->get('orderby', 'asc');

        $countries = Country::withCount('hasAddresses')
            ->orderBy($sort, $order)
            ->limit($limit)
            ->paginate(25);

        return new CountryCollection($countries);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $cca3
     * @return CountryResource
     */
    public function show(string $cca3)
    {
        $country = Country::where('cca3', $cca3)
            ->withCount('hasAddresses')
            ->firstOrFail();

        return new CountryResource($country);
    }

}
