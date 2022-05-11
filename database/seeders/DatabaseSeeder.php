<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemLookupTableSeeder::class);
        $this->call(SystemSettingsTableSeeder::class);
        $this->call(ActionsAndRoutesTableSeeder::class);
        $this->call(SystemRolesAndUsersTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(InquiriesTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(PoliciesTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(NewslettersTableSeeder::class);
    }
}
