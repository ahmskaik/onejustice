<?php

namespace Database\Seeders;

use App\Models\InquiryModel;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class InquiriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(0, 30) as $i) {
            InquiryModel::create([
                'name' => $faker->name,
                'email' => $faker->freeEmail,
                'mobile' => $faker->phoneNumber,
                'title' => Arr::random([$faker->text(50), null]),
                'message' => $faker->realText(),
                'ip' => $faker->ipv4,
                'device_name' => $faker->linuxProcessor,
                'device_systemName' => $faker->userAgent,
                'device_systemVersion' => $faker->time(),
                'seen_at' => Arr::random([$faker->dateTime, null]),
            ]);
        }
    }
}
