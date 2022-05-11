<?php

namespace App\Http\Controllers;

use App\Models\PolicyModel;
use App\Models\SystemLookupModel;
use Illuminate\Http\Request;

class PolicyController extends SiteController
{
    public function accessibility(Request $request)
    {
        $data = $this->getContent(SystemLookupModel::getIdByKey('SITE_POLICY_ACCESSIBILITY'));
        if (!$data)
            return redirect()->to(route('site.home'));

        parent::$data["title"] = $data->title;
        parent::$data["data"] = $data;
        parent::$data["active_tab"] = 'accessibility';

        return view('site.pages.details', parent::$data);
    }

    public function safety(Request $request)
    {
        $data = $this->getContent(SystemLookupModel::getIdByKey('SITE_POLICY_SAFETY'));
        if (!$data)
            return redirect()->to(route('site.home'));

        parent::$data["title"] = $data->title;
        parent::$data["data"] = $data;
        parent::$data["active_tab"] = 'safety';

        return view('site.pages.details', parent::$data);
    }

    public function terms(Request $request)
    {
        $data = $this->getContent(SystemLookupModel::getIdByKey('SITE_POLICY_TERMS'));
        if (!$data)
            return redirect()->to(route('site.home'));

        parent::$data["title"] = $data->the_title;
        parent::$data["data"] = $data;
        parent::$data["active_tab"] = 'terms';

        return view('site.pages.details', parent::$data);
    }

    public function about(Request $request)
    {
        $data = $this->getContent(SystemLookupModel::getIdByKey('SITE_POLICY_ABOUT_US'));
        if (!$data)
            return redirect()->to(route('site.home'));

        parent::$data["title"] = $data->the_title;
        parent::$data["data"] = $data;
        parent::$data["active_tab"] = 'about_us';

        return view('site.pages.details', parent::$data);
    }

    protected function getContent($type)
    {
        $locale = parent::$data["locale"];
        return PolicyModel::query()->where('type_id', $type)
            ->select(["title->$locale as the_title", "body->$locale as the_body"])->first();

    }
}
