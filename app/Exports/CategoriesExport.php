<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all();
    }

    /**
     * @var Category $category
     */
    public function map($category): array
    {
        return [
            $category->slug,
            $category->name,
            $category->icon_image,
            $category->icon_style,
            $category->icon_color,
            $category->translations,
            $category->descriptions,
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
