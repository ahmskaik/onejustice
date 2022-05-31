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
        $faker = Factory::create();

        $path = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts');
        $files = \File::files($path);

        foreach (range(0, 950) as $i) {
            $post = \App\Models\PostModel::create(
                [
                    'title' => $faker->sentence(rand(5, 15)),
                    'summary' => $faker->text,
                    'body' => $faker->realText(rand(100, 5000)),
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

            \DB::table('post_countries')->insert(['country_id' => rand(1, 40), 'post_id' => $post->id]);

        }
    }
}
