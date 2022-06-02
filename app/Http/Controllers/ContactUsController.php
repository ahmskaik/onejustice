<?php

namespace App\Http\Controllers;

use App\Models\InquiryModel;
use App\Models\PolicyModel;
use App\Models\SystemLookupModel;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ContactUsController extends SiteController
{
    public function index(Request $request)
    {
        parent::$data["content"] = PolicyModel::where('type_id', SystemLookupModel::getIdByKey('SITE_POLICY_CONTACT_US'))
            ->select(['title->' . parent::$data["locale"] . ' as the_title', 'body->' . parent::$data["locale"] . ' as the_body'])->first();

        return view('site.contact.form', parent::$data);
    }

    public function submit(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required'],
        ]);
        $attributes['ip'] = \Request::ip();
        $attributes['device_name'] ='';
        $attributes['device_systemName'] ='';

        InquiryModel::create($attributes);
        return redirect()->to(route('site.contact.index'))->with("success", trans('site.contact_us_page.message_received'));

    }
}
