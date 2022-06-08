<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Region;
use App\Models\Subcategory;
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

        $country = $request->get('country', null);
        $region = $request->get('region', null);
        $category = $request->get('category', null);

        if($country || $region || $category) {
            $addresses = Address::when($country, function ($query, $country) {
                    $query->where('country_cca3', $country);
                })
                ->when($region, function ($query, $region) {
                    $isRegion = Region::where('slug', $region)->firstOrFail();
                    $query->where('region_uuid', $isRegion->uuid);
                })
                ->when($category, function ($query, $category) {
                    $isCategory = Subcategory::where('slug', $category)->firstOrFail();
                    $query->where('subcategory_slug', $isCategory->slug);
                })
                ->where('place_status', 1)
                ->orderBy($sort, $order)
                ->limit($limit)
                ->get();
        }
        elseif($limit) {
            $addresses = Address::where('place_status', 1)
                ->orderBy($sort, $order)
                ->limit($limit)
                ->get();
        } else {
            $addresses = Address::where('place_status', 1)
                ->get();
        }

        return new AddressCollection($addresses);
    }

    /**
     * Display a GeoJSON of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|string
     */
    public function geojson(Request $request)
    {
        $limit = $request->get('limit', null);
        $sort = $request->get('sortby', 'place_name');
        $order = $request->get('orderby', 'asc');

        $country = $request->get('country', null);
        $region = $request->get('region', null);
        $category = $request->get('category', null);

        if($country || $region || $category) {
            $addresses = Address::when($country, function ($query, $country) {
                $query->where('country_cca3', $country);
            })
                ->when($region, function ($query, $region) {
                    $isRegion = Region::where('slug', $region)->firstOrFail();
                    $query->where('region_uuid', $isRegion->uuid);
                })
                ->when($category, function ($query, $category) {
                    $isCategory = Subcategory::where('slug', $category)->firstOrFail();
                    $query->where('subcategory_slug', $isCategory->slug);
                })
                ->where('place_status', 1)
                ->orderBy($sort, $order)
                ->limit($limit)
                ->get();
        }
        elseif($limit) {
            $addresses = Address::where('place_status', 1)
                ->orderBy($sort, $order)
                ->limit($limit)
                ->get();
        } else {
            $addresses = Address::where('place_status', 1)
                ->get();
        }

        $json = json_decode($addresses);
        $features = [];

        foreach($json as $key => $value) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        (float)$value->address_lat,
                        (float)$value->address_lon,
                    ]
                ],
                'properties' => [
                    'uuid' => $value->uuid,
                    'name' => $value->place_name,
                    'address_number' => $value->address_number,
                    'address_street' => $value->address_street,
                    'address_postcode' => $value->address_postcode,
                    'address_city' => $value->address_city,
                    'description' => $value->description,
                ],
            ];
        };

        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);
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
