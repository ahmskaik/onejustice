<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class NewslettersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(0, 80) as $i) {
            \App\Models\NewsletterModel::create(
                [
                    'title' => $faker->sentence(rand(5, 15)),
                    'body' => \Arr::random([null, $faker->realText(rand(100, 5000))]),
                    'language_id' => \App\Models\LanguageModel::inRandomOrder()->Active()->first()->id,
                    'date' => $faker->dateTimeThisYear,
                    'cover_image' => '',
                    'link' => $faker->url,
                    'is_active' => $faker->boolean,
                    'created_by' => 1,
                ]);
        }
    }
}
