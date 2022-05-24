<?php

namespace App\Exports;

use App\Models\Address;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class AddressesExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Address::all();
    }

    /**
     * @var Address $address
     */
    public function map($address): array
    {
        return [
            $address->place_name,
            $address->place_status,
            $address->address_number,
            $address->address_street,
            $address->address_postcode,
            $address->address_city,
            $address->country_cca3,
            $address->address_lat,
            $address->address_lon,
            $address->description,
            $address->details['phone'],
            $address->details['website'],
            $address->details['wikidata'],
            $address->subcategory_slug,
            $address->osm_id,
        ];
    }

    public function headings(): array
    {
        return [
            'place_name', // A
            'place_status', // B
            'address_number', // C
            'address_street', // D
            'address_postcode', // E
            'address_city', // F
            'country_cca3', // G
            'address_lat', // H
            'address_lon', // I
            'description', // J
            'phone', // K
            'website', // L
            'wikidata', // M
            'subcategory_slug', // N
            'osm_id', // O
        ];
    }

    public function columnFormats(): array
    {
        return [
//            'A' => DataType::TYPE_STRING,
//            'B' => DataType::TYPE_BOOL,
//            'C' => DataType::TYPE_STRING,
//            'D' => DataType::TYPE_STRING,
//            'E' => DataType::TYPE_STRING,
//            'F' => DataType::TYPE_STRING,
//            'G' => DataType::TYPE_STRING,
//            'K' => DataType::TYPE_NUMERIC,
        ];
    }
}
