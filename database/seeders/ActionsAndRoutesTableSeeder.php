<?php

namespace Database\Seeders;

use App\Models\ActionModel;
use App\Models\ActionRouteModel;
use Illuminate\Database\Seeder;

class ActionsAndRoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Setting Management
        $action = ActionModel::create(['icon' => 'fa fa-cog', 'menu_group_name' => [], 'name' => ["en" => "Update Settings", "ar" => "إعدادات النظام"], 'group_name' => 'Setting Management', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'edit_setting', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'update_setting', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        //End Setting Management

        //System Role Management
        $action = ActionModel::create(['icon' => 'flaticon-users-1', 'menu_group_name' => ["en" => "Roles and Users", "ar" => "المجموعات والمستخدمون"], 'name' => ["en" => "View Role List", "ar" => "عرض المجموعات"], 'group_name' => 'Roles and Users', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'role_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'role_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Change Role Status", "ar" => "تغيير حالة المجموعة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'change_role_status', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Create New Role", "ar" => "انشاء مجموعة جديدة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'create_role', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'store_role', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Edit Role", "ar" => "تعديل المجموعة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'edit_role', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'update_role', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Delete Role", "ar" => "حذف المجموعة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'role_delete', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        //End System Role Management

        //System User Management
        $action = ActionModel::create(['icon' => 'fa fa-user', 'name' => ["en" => "View User List", "ar" => "عرض المستخدمين"], 'group_name' => 'View User List', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => NULL, 'parent_action_id_menu' => 2]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'user_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'user_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Change User Status", "ar" => "تغير حالة المستخدم"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => 7, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'change_user_status', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Change User Password", "ar" => "تغيير كلمة مرور السمتخدم"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => 7, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'change_user_password', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Change User Role", "ar" => "تغيير مجموعة المستخدم"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => 7, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'change_user_role', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Add New User", "ar" => "إضافة مستخدم جديد"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => 7, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'store_user', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'create_user', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Edit User", "ar" => "تعديل بيانات المستخدم"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 5, 'parent_action_id' => 7, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'edit_user', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'update_user', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Delete User", "ar" => "حذف المستخدم"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 6, 'parent_action_id' => 7, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'user_delete', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        //End System User Management


        //Categories Management
        $action = ActionModel::create(['icon' => 'fa fa-cubes', 'name' => ["en" => "Categories", "ar" => "التصنيفات"], 'group_name' => 'Categories Management', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'category_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'category_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);

        $subAction = ActionModel::create(['icon' => null, 'name' => ["en" => "Add New Category", "ar" => "الحالة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'create_category', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'store_category', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);

        $subAction = ActionModel::create(['icon' => null, 'name' => ["en" => "Edit Category", "ar" => "الحالة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'edit_category', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'update_category', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);

        $subAction = ActionModel::create(['icon' => null, 'name' => ["en" => "Delete Category", "ar" => "الحالة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'delete_category', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => false]);
        //End Categories Management

        //Posts Management
        $action = ActionModel::create(['icon' => 'flaticon2-list-2', 'name' => ["en" => "Posts & Articles", "ar" => "المقالات والأخبار"], 'group_name' => 'Posts & Articles', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 5, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'posts_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'posts_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Change Post Status", "ar" => "تغيير حالة المقال"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'change_post_status', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Create New Post", "ar" => "إضافة مقال جديد"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'create_post', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'store_post', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Edit Post", "ar" => "تعديل المقال"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'edit_post', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'update_post', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Delete Post", "ar" => "حذف المقال"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'delete_post', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        //End Posts Management

        //Events Management
        $action = ActionModel::create(['icon' => 'la la-bullhorn', 'name' => ["en" => "Events", "ar" => "الفعاليات"], 'group_name' => 'Events', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 6, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'events_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'events_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Change Event Status", "ar" => "تغيير حالة الفعالية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'change_event_status', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Create New Event", "ar" => "إضافة فعالية جديدة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'create_event', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'store_event', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Edit Event", "ar" => "الفعالية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'edit_event', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'update_event', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Delete Event", "ar" => "حذف الفعالية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'delete_event', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        //End Events Management

        //Policies Management
        $action = ActionModel::create(['icon' => 'flaticon-globe', 'name' => ["en" => "Website Policies", "ar" => "سياسات الموقع"], 'group_name' => 'Website Policies', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 8, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'show_pages', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'update_pages', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        //End Policies Management

        //Inquiries Management
        $action = ActionModel::create(['icon' => 'flaticon-chat', 'name' => ["en" => "Inquiries", "ar" => "رسائل الزّوار"], 'group_name' => 'Inquiries Management', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 9, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'inquiry_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'inquiry_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => null, 'name' => ["en" => "Show Inquiry Details", "ar" => "عرض تفاصيل الرسالة"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'inquiry_show', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        //End Inquiries Management

        //Mails Management
        $action = ActionModel::create(['icon' => 'fab fa-mailchimp', 'name' => ["en" => "Campaigns", "ar" => "النشرات البريدية"], 'group_name' => 'Mails & Notifications', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 10, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'campaign_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'campaign_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'campaign_preview', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Delete Campaign", "ar" => "حذف الحملة البريدية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_delete', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Replicate Campaign", "ar" => "تكرار الحملة البريدية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_replicate', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Send Campaign", "ar" => "إرسال الحملة البريدية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_send', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_send_test', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Add New Campaign", "ar" => "إنشاء حملة بريدية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_create', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_store', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Edit Campaign", "ar" => "تعديل الحملة البريدية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 5, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_edit', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'campaign_update', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Maillist", "ar" => "القوائم البريدية"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 6, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'maillist_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'maillist_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'maillist_add', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'maillist_edit', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'maillist_delete', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Campaign Reports", "ar" => "تقارير الحملات البريدية"], 'group_name' => NULL, 'is_menuItem' => false, 'is_active' => true, 'menu_order' => 10, 'parent_action_id' => $action->id, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_unsubscribeList', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_unsubscribe', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_openedList', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_overview', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_opened', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_notOpenedList', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_notOpened', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_sendToList', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_sendTo', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_complained', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'reports_overview', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Groups", "ar" => "المجموعات البريدية"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 11, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_view', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_list', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_delete', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_create', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_store', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_edit', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'groups_update', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        //End Mails Management

        //Reports Management
        $action = ActionModel::create(['icon' => 'flaticon2-line-chart', 'name' => ["en" => "Visitors", "ar" => "الزيارات"], 'group_name' => 'Reports Management', 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 11, 'parent_action_id' => NULL, 'parent_action_id_menu' => NULL]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'visitorsView', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $action->id, 'route_name' => 'visitors', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Keywords", "ar" => "الكلمات المفتاحية"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 1, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'keywordsView', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'keywords', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Country", "ar" => "المناطق الجغرافية"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 2, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'countryView', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'country', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Referrers", "ar" => "التحويلات"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 3, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'referrersView', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'referrers', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Browsers", "ar" => "المصتفّحات"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 4, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'browsersView', 'is_logging' => false, 'is_LoggingDetails' => false, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'browsers', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Most Visited", "ar" => "الزيارات"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 5, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'mostVisitedView', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'mostVisited', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Mobile Traffic", "ar" => "الزيارات"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 6, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'mobileTrafficView', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'mobileTraffic', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "New VS Returning", "ar" => "الارتداد"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 7, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'newVsReturningView', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'newVsReturning', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Country", "ar" => "الدولة"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 8, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'countryView', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'country', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);

        $subAction = ActionModel::create(['icon' => NULL, 'name' => ["en" => "Site Time", "ar" => "وقت التصفّج"], 'group_name' => NULL, 'is_menuItem' => true, 'is_active' => true, 'menu_order' => 9, 'parent_action_id' => $action->id, 'parent_action_id_menu' => $action->id]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'siteTimeView', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        ActionRouteModel::create(['action_id' => $subAction->id, 'route_name' => 'siteTime', 'is_logging' => true, 'is_LoggingDetails' => true, 'can_Logging' => true]);
        //End Reports Management
    }
}
