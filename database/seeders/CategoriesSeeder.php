<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the tables
        DB::table('categories__')->delete();
        DB::table('categories__subcategories')->delete();

        $file = File::get(storage_path('data/categories/categories.json'));
        $json = json_decode($file);

        foreach ($json as $data) {
            $category = Category::firstOrCreate([
                'name' => $data->name,
                'slug' => Str::slug($data->name, '-'),
            ],
            [
                'icon_image' => $data->icon_image,
                'icon_options' => $data->icon_options,
                'translations' => json_decode(json_encode($data->translations), true),
                'descriptions' => json_decode(json_encode($data->descriptions), true)
            ]);

            $category = Subcategory::firstOrCreate([
                'category_slug' => $category->slug,
                'name' => $data->name,
                'slug' => Str::slug($data->name, '-'),
            ],
            [
                'icon_image' => $data->icon_image,
                'icon_options' => $data->icon_options,
                'translations' => json_decode(json_encode($data->translations), true),
                'descriptions' => json_decode(json_encode($data->descriptions), true)
            ]);
        }
    }
}
