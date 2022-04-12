<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AddressCollection
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', null);
        $sort = $request->get('sortby', 'place_name');
        $order = $request->get('orderby', 'asc');

        if($limit) {
            $addresses = Address::orderBy($sort, $order)
                ->limit($limit)
                ->get();
        } else {
            $addresses = Address::orderBy($sort, $order)
                ->limit($limit)
                ->paginate(25);
        }

        return new AddressCollection($addresses);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return AddressResource
     */
    public function show(string $uuid)
    {
        $address = Address::findOrFail($uuid);

        return new AddressResource($address);
    }

}
