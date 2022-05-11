<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\LanguageModel::create(['name' => 'Arabic', 'translations' => ['en' => 'Arabic', 'ar' => 'العربية', 'tr' => 'Arapça'], 'iso_code' => 'ar', 'flag' => 'sa', 'language_code' => 'ar-eg', 'locale' => 'ar-eg', 'is_rtl' => true, 'sort_order' => 1, 'is_active' => true, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'English', 'translations' => ['en' => 'English', 'ar' => 'الانجليزية', 'tr' => 'İngilizce'], 'iso_code' => 'en', 'flag' => 'gb', 'language_code' => 'en-us', 'locale' => 'en-us', 'is_rtl' => false, 'sort_order' => 2, 'is_active' => true, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'Turkish', 'translations' => ['en' => 'Turkish', 'ar' => 'التركية', 'tr' => 'Türkçe'], 'iso_code' => 'tr', 'flag' => 'tr', 'language_code' => 'tur', 'locale' => 'tr', 'is_rtl' => false, 'sort_order' => 3, 'is_active' => true, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'French', 'translations' => ['en' => 'French', 'ar' => 'الفرنسية', 'tr' => 'Fransızca'], 'iso_code' => 'fr', 'flag' => 'fr', 'language_code' => 'fr', 'locale' => 'fr', 'is_rtl' => false, 'sort_order' => 5, 'is_active' => true, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'Spanish', 'translations' => ['en' => 'Spanish', 'ar' => 'الاسبانية', 'tr' => 'Spanish'], 'iso_code' => 'es', 'flag' => 'es', 'language_code' => 'es', 'locale' => 'es', 'is_rtl' => false, 'sort_order' => 4, 'is_active' => false, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'Italian', 'translations' => ['en' => 'Italian', 'ar' => 'الايطالية', 'tr' => 'Italian'], 'iso_code' => 'it', 'flag' => 'it', 'language_code' => 'it', 'locale' => 'it', 'is_rtl' => false, 'sort_order' => 6, 'is_active' => false, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'German', 'translations' => ['en' => 'German', 'ar' => 'الألمانية', 'tr' => 'German'], 'iso_code' => 'de', 'flag' => 'de', 'language_code' => 'de', 'locale' => 'de', 'is_rtl' => false, 'sort_order' => 7, 'is_active' => false, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'Chinese', 'translations' => ['en' => 'Chinese', 'ar' => 'الصينية', 'tr' => 'Chinese'], 'iso_code' => 'zh', 'flag' => 'cn', 'language_code' => 'zh', 'locale' => 'zh', 'is_rtl' => false, 'sort_order' => 8, 'is_active' => false, 'created_by' => 1]);
        \App\Models\LanguageModel::create(['name' => 'Russian', 'translations' => ['en' => 'Russian', 'ar' => 'الروسية', 'tr' => 'Russian'], 'iso_code' => 'ru', 'flag' => 'ru', 'language_code' => 'ru', 'locale' => 'ru', 'is_rtl' => false, 'sort_order' => 9, 'is_active' => false, 'created_by' => 1]);
    }
}
