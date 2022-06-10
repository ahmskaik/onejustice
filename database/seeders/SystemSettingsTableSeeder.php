<?php

namespace Database\Seeders;

use App\Models\SettingModel;
use Illuminate\Database\Seeder;

class SystemSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SettingModel::create(['name' => 'is_open', 'sysset_data' => [true]]);
        SettingModel::create(['name' => 'social_accounts', 'sysset_data' =>
            [
                'facebook' => 'facebook.com',
                'twitter' => 'twitter.com',
                'youtube' => 'youtube.com',
                'flickr' => 'flickr.com',
                'instagram' => 'instagram.com',
            ]
        ]);
        SettingModel::create(['name' => 'meta_description', 'sysset_data' => ['en' => 'meta description', 'ar' => 'meta description', 'tr' => 'meta description']]);
        SettingModel::create(['name' => 'welcome_message', 'sysset_data' => ['en' => 'welcome_message', 'ar' => 'welcome_message', 'tr' => 'welcome_message']]);
        SettingModel::create(['name' => 'app_brand', 'sysset_data' => ['en' => 'welcome_message', 'ar' => 'welcome_message', 'tr' => 'welcome_message']]);
        SettingModel::create(['name' => 'contact_phone', 'sysset_data' => ['009058745555']]);
        SettingModel::create(['name' => 'contact_email', 'sysset_data' => ['admin@example.com']]);
        SettingModel::create(['name' => 'active_theme', 'sysset_data' => [2]]);
    }
}
