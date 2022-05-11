<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemLookupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('system_lookup')->insert(['id' => 1, 'name_id' => 'ROLE_STATUS', 'syslkp_data' => '{"en": "Status","ar": "الحالة"}', 'parent_id' => NULL, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 2, 'name_id' => 'ROLE_STATUS_ACTIVE', 'syslkp_data' => '{"en": "Active","ar": "فعال"}', 'parent_id' => 1, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 3, 'name_id' => 'ROLE_STATUS_INACTIVE', 'syslkp_data' => '{"en": "InActive","ar": "غير فعال"}', 'parent_id' => 1, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);

        \DB::table('system_lookup')->insert(['id' => 4, 'name_id' => 'SYSTEM_USER_STATUS', 'syslkp_data' => '{"en": "Status","ar": "الحالة"}', 'parent_id' => NULL, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 5, 'name_id' => 'SYSTEM_USER_STATUS_ACTIVE', 'syslkp_data' => '{"en": "Active","ar": "فعال"}', 'parent_id' => 4, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 6, 'name_id' => 'SYSTEM_USER_STATUS_INACTIVE', 'syslkp_data' => '{"en": "InActive","ar": "غير فعال"}', 'parent_id' => 4, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);

        \DB::table('system_lookup')->insert(['id' => 7, 'name_id' => 'CATEGORY_STATUS', 'syslkp_data' => '{"en": "Status","ar": "الحالة"}', 'parent_id' => NULL, 'order' => 3, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 8, 'name_id' => 'CATEGORY_STATUS_ACTIVE', 'syslkp_data' => '{"en": "Active","ar": "فعال"}', 'parent_id' => 7, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 9, 'name_id' => 'CATEGORY_STATUS_INACTIVE', 'syslkp_data' => '{"en": "InActive","ar": "غير فعال"}', 'parent_id' => 7, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);

        \DB::table('system_lookup')->insert(['id' => 10, 'name_id' => 'POST_TYPE', 'syslkp_data' => '{"en": "Type","ar": "النوع"}', 'parent_id' => NULL, 'order' => 4, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 11, 'name_id' => 'POST_TYPE_ARTICLE', 'syslkp_data' => '{"en": "Article","ar": "مقال","icon":""}', 'parent_id' => 10, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 12, 'name_id' => 'POST_TYPE_IMAGE', 'syslkp_data' => '{"en": "Image","ar": "صورة","icon":"fa fa-2 fa-camera"}', 'parent_id' => 10, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 13, 'name_id' => 'POST_TYPE_VIDEO', 'syslkp_data' => '{"en": "Video","ar": "فيديو","icon":"fa fa-2 fa-play"}', 'parent_id' => 10, 'order' => 3, 'is_active' => true, 'system_user_id' => 1]);

        \DB::table('system_lookup')->insert(['id' => 14, 'name_id' => 'POST_STATUS', 'syslkp_data' => '{"en": "Status","ar": "الحالة"}', 'parent_id' => NULL, 'order' => 5, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 15, 'name_id' => 'POST_STATUS_DRAFT', 'syslkp_data' => '{"class":"info","en": "Draft","ar": "مسودّة"}', 'parent_id' => 14, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 16, 'name_id' => 'POST_STATUS_PUBLISHED', 'syslkp_data' => '{"class":"success","en": "Published","ar": "منشور"}', 'parent_id' => 14, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 17, 'name_id' => 'POST_STATUS_SCHEDULED', 'syslkp_data' => '{"class":"primary","en": "Scheduled","ar": "مجدول"}', 'parent_id' => 14, 'order' => 3, 'is_active' => true, 'system_user_id' => 1]);

        \DB::table('system_lookup')->insert(['id' => 18, 'name_id' => 'SITE_POLICY', 'syslkp_data' => '{"en": "Policy","ar": "سياسات"}', 'parent_id' => NULL, 'order' => 6, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 19, 'name_id' => 'SITE_POLICY_ABOUT_US', 'syslkp_data' => '{"en": "About Us","ar": "من نحن"}', 'parent_id' => 18, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 20, 'name_id' => 'SITE_POLICY_TERMS', 'syslkp_data' => '{"en": "Terms and Conditions","ar": "شروط الاستخدام"}', 'parent_id' => 18, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 21, 'name_id' => 'SITE_POLICY_SAFETY', 'syslkp_data' => '{"en": "Safety","ar": "السلامة"}', 'parent_id' => 18, 'order' => 3, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 22, 'name_id' => 'SITE_POLICY_ACCESSIBILITY', 'syslkp_data' => '{"en": "Accessibility","ar": "الوصول للبيانات"}', 'parent_id' => 18, 'order' => 4, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 23, 'name_id' => 'SITE_POLICY_CONTACT_US', 'syslkp_data' => '{"en": "Accessibility","ar": "الوصول للبيانات"}', 'parent_id' => 18, 'order' => 5, 'is_active' => true, 'system_user_id' => 1]);

        \DB::table('system_lookup')->insert(['id' => 24, "slug" => "", 'name_id' => 'EVENT_TYPE', 'syslkp_data' => '{"en": "Type","ar": "النوع"}', 'parent_id' => NULL, 'order' => 7, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 25, "slug" => "seminars", 'name_id' => 'EVENT_TYPE_SEMINAR', 'syslkp_data' => '{"en": "SEMINARS & CONFERENCE","ar": "مؤتمرات"}', 'parent_id' => 24, 'order' => 1, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 26, "slug" => "take-action", 'name_id' => 'EVENT_TYPE_TAKE_ACTION', 'syslkp_data' => '{"en": "Take Action","ar": "شارك"}', 'parent_id' => 24, 'order' => 2, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 27, "slug" => "webinars", 'name_id' => 'EVENT_TYPE_WEBINAR', 'syslkp_data' => '{"en": "Webinars","ar": "لقاءات"}', 'parent_id' => 24, 'order' => 3, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 28, "slug" => "our-events", 'name_id' => 'EVENT_TYPE_OUR_EVENTS', 'syslkp_data' => '{"en": "Our Events","ar": "فعالياتنا"}', 'parent_id' => 24, 'order' => 4, 'is_active' => true, 'system_user_id' => 1]);
        \DB::table('system_lookup')->insert(['id' => 29, "slug" => "public", 'name_id' => 'EVENT_TYPE_OTHERS', 'syslkp_data' => '{"en": "Other Events and Activities","ar": "فعاليات"}', 'parent_id' => 24, 'order' => 5, 'is_active' => true, 'system_user_id' => 1]);

    }
}
