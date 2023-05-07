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
        $faker_ar = Factory::create("ar_SA");

        $path = public_path('uploads' . DIRECTORY_SEPARATOR . 'posts');
        $files = \File::files($path);
        $categories = \App\Models\CategoryModel::get()->pluck('id')->toArray();
        $statuses = \App\Models\SystemLookupModel::getLookeupByKey("POST_STATUS")->pluck('id')->toArray();
        $languages = \App\Models\LanguageModel::Active()->pluck('id')->toArray();

        $types = \App\Models\SystemLookupModel::getLookeupByKey("POST_TYPE")->pluck('id')->toArray();

        foreach (range(0, 850) as $i) {
            $lang = \Arr::random($languages);
            $post = \App\Models\PostModel::create(
                [
                    //'title' => $faker->sentence(rand(5, 15)),
                    'title' => $lang == 1 ? $faker_ar->realText(rand(50, 100)) : $faker->realText(rand(50, 100)),
                    'summary' => $lang == 1 ? $faker_ar->realText(rand(100, 300)) : $faker->realText(rand(100, 300)),
                    'body' => $lang == 1 ? $faker_ar->realText(rand(100, 5000)) : $faker->realText(rand(100, 5000)),
                    'status_id' => \Arr::random($statuses),
                    'category_id' => \Arr::random($categories),
                    'language_id' => $lang,
                    'type_id' => \Arr::random($types),
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
