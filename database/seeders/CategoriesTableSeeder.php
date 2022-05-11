<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data =
            [
                ['slug' => 'publications', 'name' => ['en' => 'Publications', 'ar' => 'اصدارات', 'tr' => 'Publications']],
                ['slug' => 'reports', 'name' => ['en' => 'Reports', 'ar' => 'تقارير', 'tr' => 'Reports']],
                ['slug' => 'statements', 'name' => ['en' => 'Statements', 'ar' => 'بيانات', 'tr' => 'Statements']],
                ['slug' => 'media', 'name' => ['en' => 'Media', 'ar' => 'وسائط', 'tr' => 'Media']],
/*
                ['parent_id' => 1, 'slug' => 'annual-reports', 'name' => ['en' => 'Europe/Palestine Annual Reports', 'ar' => 'تقارير سنوية', 'tr' => 'Europe/Palestine Annual Reports']],
                ['parent_id' => 1, 'slug' => 'monthly-reports', 'name' => ['en' => 'Europe/Palestine Monthly Reports', 'ar' => 'تقارير شهرية', 'tr' => 'Europe/Palestine Monthly Reports']],
                ['parent_id' => 1, 'slug' => 'israel-lobby-in-europe', 'name' => ['en' => 'Israel Lobby in Europe', 'ar' => 'اللوبي الاسرائيلي في أوروبا', 'tr' => 'Israel Lobby in Europe']],
                ['parent_id' => 1, 'slug' => 'political-analysis', 'name' => ['en' => 'Political Analysis', 'ar' => 'تحليلات سياسية', 'tr' => 'Political Analysis']],
                ['parent_id' => 1, 'slug' => 'europe-palestine-relations', 'name' => ['en' => 'Europe/Palestine Relations', 'ar' => 'العلاقات الأوروبية الفلسطينية', 'tr' => 'Europe/Palestine Relations']],
                ['parent_id' => 1, 'slug' => 'delegation-reports', 'name' => ['en' => 'Delegation Reports', 'ar' => 'تقارير التفويض', 'tr' => 'Delegation Reports']],

                ['parent_id' => 2, 'slug' => 'press-releases', 'name' => ['en' => 'Press releases', 'ar' => 'نشرات', 'tr' => 'Press releases']],
                ['parent_id' => 2, 'slug' => 'news_from_palestine', 'name' => ['en' => 'News from Palestine', 'ar' => 'أخبار فلسطين', 'tr' => 'News from Palestine']],
                ['parent_id' => 2, 'slug' => 'news-from-europe', 'name' => ['en' => 'News from Europe', 'ar' => 'أخبار أوروبا', 'tr' => 'News from Europe']],
                ['parent_id' => 2, 'slug' => 'world-news', 'name' => ['en' => 'World News', 'ar' => 'أخبار دولية', 'tr' => 'World News']],
                ['parent_id' => 2, 'slug' => 'recommended-articles', 'name' => ['en' => 'Recommended Articles', 'ar' => 'مقالات مختارة', 'tr' => 'Recommended Articles']],
                ['parent_id' => 2, 'slug' => 'recommended-websites', 'name' => ['en' => 'Recommended News Websites', 'ar' => 'مواقع مختارة', 'tr' => 'Recommended News Websites']],

                ['parent_id' => 3, 'slug' => 'europal-leaflets', 'name' => ['en' => 'Europal Leaflets', 'ar' => 'منشورات يوروبال', 'tr' => 'Europal Leaflets']],
                ['parent_id' => 3, 'slug' => 'recommended-reports', 'name' => ['en' => 'Recommended Reports', 'ar' => 'تقارير مقترحة', 'tr' => 'Recommended Reports']],
                ['parent_id' => 3, 'slug' => 'our-publications', 'name' => ['en' => 'Our Publications', 'ar' => 'اصداراتنا', 'tr' => 'our publications']],*/

            ];
        $faker = Factory::create();

        foreach ($data as $item) {
            \App\Models\CategoryModel::create([
                'slug' => $item['slug'],
                'name' => $item['name'],
                'is_active' => true,
                'parent_id' => isset($item['parent_id']) ? $item['parent_id'] : null,
                'is_featured' => $faker->boolean,
                'icon' => '',
                'main_image' => '',
                'created_by' => 1
            ]);
        }
    }
}
