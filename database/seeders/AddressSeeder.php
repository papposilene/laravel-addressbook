<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'museum',
            'gallery',
            'library',
            'foundation',
            'art center',
            'art fair',
            'other'
        ];

        // Drop the table
        DB::table('addresses__')->delete();

        foreach ($addresses as $data)
        {
            Address::create([
                'type' => $data,
                'slug' => Str::slug($data, '-'),
            ]);
        }
    }
}
