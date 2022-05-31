<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create("ar_JO");//ar_AE

        $path = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts');
        $files = \File::files($path);

        foreach (range(0, 350) as $i) {
            $post = \App\Models\PostModel::create(
                [
                    'title' => $faker->firstName . ' ' . $faker->lastName . ' ' . $faker->firstName . ' ' . $faker->lastName,
                    'summary' => $faker->text,
                    'body' => $faker->text(rand(100, 5000)),
                    'status_id' => \Arr::random(\App\Models\SystemLookupModel::getLookeupByKey("POST_STATUS")->pluck('id')->toArray()),
                    'category_id' => \App\Models\CategoryModel::inRandomOrder()->first()->id,
                    'language_id' => \App\Models\LanguageModel::inRandomOrder()->Active()->first()->id,
                    'type_id' => \Arr::random(\App\Models\SystemLookupModel::getLookeupByKey("POST_TYPE")->pluck('id')->toArray()),
                    'is_featured' => $faker->boolean,
                    'date' => $faker->dateTimeThisYear,
                    'cover_image' => \Arr::random($files)->getFilename(),
                    'views' => $faker->numberBetween(0, 1542),
                    'tags' => null,
                    'created_by' => 1,
                ]);
            foreach (range(0, rand(1, 3)) as $i) {
                \DB::table('post_countries')->insert(['country_id' => rand(1, 100), 'post_id' => $post->id]);

            }

        }
    }
}
