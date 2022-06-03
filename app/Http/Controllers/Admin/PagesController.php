<?php

namespace App\Http\Controllers\Admin;

use App\Models\PolicyModel;
use App\Models\SystemLookupModel;
use Illuminate\Http\Request;

class PagesController extends SuperAdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'show_pages';
        parent::$data['route'] = 'pages';

        parent::$data['active_menuPlus'] = 'show_pages';
        parent::$data["breadcrumbs"] = ["Dashboard" => parent::$data['cp_route_name'],
            "Pages" => parent::$data['cp_route_name'] . "/" . parent::$data['route']];
    }

    public function editPages()
    {
        parent::$data["about_us"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_ABOUT_US'))->first();
        parent::$data["terms"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_TERMS'))->first();
        parent::$data["safety"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_SAFETY'))->first();
        parent::$data["accessibility"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_ACCESSIBILITY'))->first();
        parent::$data["contact_us"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_CONTACT_US'))->first();
        parent::$data['show_current_date'] = false;
        parent::$data["show_language_bar"] = true;

        if (\Session::has("success"))
            parent::$data["success"] = \Session::get("success");

        parent::$data["tabIndex"] = "#about_us";

        if (\Session::has("tabIndex"))
            parent::$data["tabIndex"] = \Session::get("tabIndex");

        if (\Session::has("errors"))
            parent::$data["errorsCount"] = \Session::get("errors");

        parent::$data["breadcrumbs"]["Edit"] = "";
        parent::$data["title"] = '';
        parent::$data["page_title"] = "Static Pages";

        return view("cp.pages.edit", parent::$data);
    }

    public function updatePages(Request $request)
    {
        $pages = [];
        $pages["about_us"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_ABOUT_US'))->first();
        $pages["terms"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_TERMS'))->first();
        $pages["safety"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_SAFETY'))->first();
        $pages["accessibility"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_ACCESSIBILITY'))->first();
        $pages["contact_us"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_CONTACT_US'))->first();

        foreach ($pages as $key => $post) {
            $post->update(
                [
                    'title' => $request->input($key)['title'] ?? '',
                    'body' => $request->input($key)['body'] ?? ''
                ]);
        }

        return redirect(parent::$data['cp_route_name'] . "/" . parent::$data['route'])
            ->with(["success" => "Updated Successfully", "tabIndex" => $request->input("tabIndex")]);
    }

}
