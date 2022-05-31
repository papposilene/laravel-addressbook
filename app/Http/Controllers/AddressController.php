<?php

namespace App\Http\Controllers;

use App\Exports\AddressesExport;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class AddressController extends Controller
{
    /**
     * Export the categories.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel()
    {
        $date = date('Y_m_d_hh_ii_ss');

        return Excel::download(new AddressesExport, 'cartography_addresses_' . $date . '.xlsx');
    }

    /**
     * Export all the addresses.
     */
    public function exportJson()
    {
        $date = date('Y_m_d_his');
        $zipFile = storage_path('extracts/cartography_addresses_extracts.zip');
        $countries = Country::withCount('hasAddresses')->get();

        foreach ($countries->where('has_addresses_count', '>', 0) as $country) {
            $body = [];
            $name = 'cartography_addresses_' . $country->cca3 . '_' . $date . '.json';

            foreach ($country->hasAddresses()->get() as $address) {
                $body[] = [
                    'geolocation' => [
                        'lat' => $address->address_lat,
                        'lon' => $address->address_lon,
                        'osm_id' => $address->osm_id,
                    ],
                    'category' => [
                        'category' => $address->belongsToCategory->slug,
                        'subcategory' => $address->subcategory_slug,
                    ],
                    'name' => $address->place_name,
                    'address' => [
                        'address_number' => $address->address_number,
                        'address_street' => $address->address_street,
                        'address_postcode' => $address->address_postcode,
                        'address_city' => $address->address_city,
                        'country_cca3' => $address->country_cca3,
                    ],
                    'details' => [
                        'status' => $address->place_status,
                        'description' => $address->description,
                        'phone' => $address->details['phone'],
                        'website' => $address->details['website'],
                        'wikidata' => $address->details['wikidata'],
                    ],
                ];
            }

            $json = [
                'country_cca3' => $country->cca3,
                'country_name' => $country->name_eng_common,
                'addresses' => $body,
            ];

            $file = json_encode($json, JSON_PRETTY_PRINT);
            File::put(storage_path('temp/' . $name), $file);
        }

        File::delete($zipFile);
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            foreach (glob(storage_path('temp/*.json')) as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        File::delete(glob(storage_path('temp/*.json')));

        return response()->download($zipFile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function delete($uuid)
    {
        $address = Address::findOrFail($uuid);
        $address->delete();

        session()->flash('message', 'Address successfully deleted.');
        return redirect()->to('/addresses');
    }
}
