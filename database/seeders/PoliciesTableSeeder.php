<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (\App\Models\SystemLookupModel::getLookeupByKey("SITE_POLICY") as $policy) {
            \App\Models\PolicyModel::create(
                [
                    'title' => ['en' => $faker->text(30), 'ar' => $faker->text(30), 'tr' => $faker->text(30)],
                    'body' => ['en' => $faker->realText(rand(100, 5000)), 'ar' => $faker->realText(rand(100, 5000)), 'tr' => $faker->realText(rand(100, 5000))],
                    'type_id' => $policy->id,
                    'created_by' => 1,
                ]);
        }
    }
}
