<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use App\Exports\SubcategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Export the categories.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCategories()
    {
        $date = date('Y_m_d_hh_ii_ss');

        return Excel::download(new CategoriesExport, 'cartography_categories_' . $date . '.xlsx');
    }

    /**
     * Export the subcategories.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportSubcategories()
    {
        $date = date('Y_m_d_hh_ii_ss');

        return Excel::download(new SubcategoriesExport, 'cartography_subcategories_' . $date . '.xlsx');
    }

}
