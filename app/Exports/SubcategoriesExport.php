<?php

namespace App\Exports;

use App\Models\Subcategory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubcategoriesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Subcategory::all();
    }

    /**
     * @var Subcategory $subcategory
     */
    public function map($subcategory): array
    {
        return [
            $subcategory->category_slug,
            $subcategory->slug,
            $subcategory->name,
            $subcategory->icon_image,
            $subcategory->icon_style,
            $subcategory->icon_color,
            $subcategory->translations,
            $subcategory->descriptions,
        ];
    }

    public function headings(): array
    {
        return [
            'slug',
            'name',
            'icon_image',
            'icon_style',
            'icon_color',
            'translations',
            'descriptions'

        ];
    }
}
