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

        // First, categories...
        $fileC = File::get(storage_path('data/categories/categories.json'));
        $jsonC = json_decode($fileC);

        foreach ($jsonC as $data) {
            $category = Category::firstOrCreate([
                'name' => $data->name,
                'slug' => Str::slug($data->name, '-'),
            ],
            [
                'icon_image' => $data->icon_image,
                'icon_style' => $data->icon_style,
                'translations' => json_decode(json_encode($data->translations), true),
                'descriptions' => json_decode(json_encode($data->descriptions), true)
            ]);
        }

        // Then, subcategories.
        $fileS = File::get(storage_path('data/categories/subcategories.json'));
        $jsonS = json_decode($fileS);

        foreach ($jsonS as $data) {
            $slug = Str::slug($data->category_slug, '-');
            $category = Category::find($slug);

            $category = Subcategory::firstOrCreate([
                'category_slug' => $category->slug,
                'name' => $data->name,
                'slug' => Str::slug($data->slug, '-'),
            ],
            [
                'icon_image' => $data->icon_image,
                'icon_style' => $data->icon_style,
                'translations' => json_decode(json_encode($data->translations), true),
                'descriptions' => json_decode(json_encode($data->descriptions), true)
            ]);
        }
    }
}
