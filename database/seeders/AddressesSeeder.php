<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the table
        DB::table('addresses__')->delete();
        DB::table('categories__')->delete();
        DB::table('subcategories__')->delete();

        foreach (glob(storage_path('data/addresses/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            foreach ($json as $data)
            {
                $category = Category::firstOrCreate([
                        'name' => $data->category,
                    ],
                    [
                        'slug' => Str::slug($data->category, '-'),
                    ]);
                $subcategory = Subcategory::firstOrCreate([
                    'name' => $data->category,
                ],
                [
                    'slug' => Str::slug($data->category, '-'),
                ]);


                Address::create([
                    'type' => $data,
                    'slug' => Str::slug($data, '-'),
                ]);
            }
        }
    }
}