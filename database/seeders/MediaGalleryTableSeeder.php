<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class MediaGalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('uploads' . DIRECTORY_SEPARATOR . 'slider');

        $files = \File::files($path);
        $faker = Factory::create();
        $order = 1;
        foreach ($files as $key => $file) {
            $slide = \App\Models\MediaGalleryModel::create([
                // 'title' => ['en' => $faker->company, 'ar' => $faker->company, 'tr' => $faker->company],
                'link' => $faker->url,
                'file_name' => $file->getFilename(),
                'type' => 'image',
                'sort_order' => $order++,
                'is_active' => $faker->boolean,
                'language_id' => \App\Models\LanguageModel::inRandomOrder()->first()->id,
                'created_by' => 1,
            ]);
        }
    }
}
