<?php

namespace App\Http\Controllers\Admin;

use App\Models\LanguageModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use Session;

class SettingController extends SuperAdminController
{

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'edit_setting';
        parent::$data["breadcrumbs"] = ["Dashboard" => parent::$data['cp_route_name'], "Settings" => ""];
    }

    public function index()
    {
        if (Session::has("success"))
            parent::$data["success"] = Session::get("success");

        parent::$data["siteSetting"] = SettingModel::pluck("sysset_data", "name")->toArray();
        parent::$data["languages"] = LanguageModel::all();

        parent::$data['title'] = "Settings";
        return view('cp.setting.form', parent::$data);
    }

    public function update(Request $request)
    {
        $this->updateSetting($request);
        return redirect(parent::$data['cp_route_name'] . "/setting")->with("success", "Updated successfully");
    }

    private function updateSetting($request)
    {
        LanguageModel::query()->update(['is_active' => false]);
        if ($request->languages)
            LanguageModel::query()->whereIn('id', $request->languages)->update(['is_active' => true]);

        $data['is_open'] = [$request->get("is_open") ? 1 : 0];
        $data['active_theme'] = [$request->get("active_theme")];
        $data['contact_phone'] = [$request->get("contact_phone")];
        $data['contact_email'] = [$request->get("contact_email")];
        $data['social_accounts'] = $request->get("social_accounts") ;

       /* $data['facebook'] = [xss_clean($request->get("facebook"))];
        $data['twitter'] = [xss_clean($request->get("twitter"))];
        $data['youtube'] = [xss_clean($request->get("youtube"))];
        $data['instagram'] = [xss_clean($request->get("instagram"))];
        $data['linkedin'] = [xss_clean($request->get("linkedin"))];*/

        $data['meta_description'] =
            [
                "en" => isset($request->get("meta_description")["en"]) ? xss_clean($request->get("meta_description")["en"]) : "",
                "ar" => isset($request->get("meta_description")["ar"]) ? xss_clean($request->get("meta_description")["ar"]) : ""
            ];

        $data['welcome_message'] =
            [
                "en" => isset($request->get("welcome_message")["en"]) ? xss_clean($request->get("welcome_message")["en"]) : "",
                "ar" => isset($request->get("welcome_message")["ar"]) ? xss_clean($request->get("welcome_message")["ar"]) : ""
            ];

        $data['app_brand'] =
            [
                "en" => isset($request->get("app_brand")["en"]) ? xss_clean($request->get("app_brand")["en"]) : "",
                "ar" => isset($request->get("app_brand")["ar"]) ? xss_clean($request->get("app_brand")["ar"]) : ""
            ];


        $this->updateAllInputs($data);
    }

    private function updateAllInputs($data)
    {
        $sett = new SettingModel;

        foreach ($data as $key => $value) {
            $sett = SettingModel::where("name", $key)->first();
            $oldValue = [$sett->name . "" => $sett->value];
            if ($oldValue != $value)
                $sett->update(["sysset_data" => $value]);
        }
    }
}
