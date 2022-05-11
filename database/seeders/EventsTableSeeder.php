<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $path = public_path('uploads' . DIRECTORY_SEPARATOR . 'events');
        $files = \File::files($path);


        foreach (range(0, 150) as $i) {

            \App\Models\EventModel::create(
                [
                    'title' => ['en' => $faker->text(30), 'ar' => $faker->text(30), 'tr' => $faker->text(30)],
                    'body' => ['en' => $faker->realText(rand(100, 5000)), 'ar' => $faker->realText(rand(100, 5000)), 'tr' => $faker->realText(rand(100, 5000))],
                    'is_active' => $faker->boolean,
                    'link' => $faker->url,
                    'type_id' => \Arr::random(\App\Models\SystemLookupModel::getLookeupByKey("EVENT_TYPE")->pluck('id')->toArray()),
                    'is_featured' => $faker->boolean,
                    'date' => $faker->dateTimeThisYear,
                    'cover_image' => \Arr::random($files)->getFilename(),
                    'views' => $faker->numberBetween(0, 1542),
                    'tags' => null,
                    'created_by' => 1,
                ]);
        }
    }
}
