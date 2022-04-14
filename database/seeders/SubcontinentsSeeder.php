<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Continent;

class ContinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(storage_path('data/geodata/countries/continents.json'));
        $json = json_decode($file);

        foreach ($json as $data) {
            Continent::updateOrCreate(
                ['name' => $data->name],
                [
                    'slug' => Str::slug($data->name, '-'),
                    'translations' => json_encode($data->translations, JSON_FORCE_OBJECT),
                ]);
        }
    }
}
