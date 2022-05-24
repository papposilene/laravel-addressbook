<?php

namespace App\Http\Controllers;

use App\Exports\AddressesExport;
use Maatwebsite\Excel\Facades\Excel;

class AddressController extends Controller
{
    /**
     * Export the categories.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $date = date('Y_m_d_hh_ii_ss');

        return Excel::download(new AddressesExport, 'cartography_addresses_' . $date . '.xlsx');
    }
}
