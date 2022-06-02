<?php

namespace App\Http\Controllers\Admin;


use App\Models\InquiryModel;
use App\Models\PostModel;

class DashboardController extends SuperAdminController
{

    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'dashboard';
    }

    public function getIndex()
    {
        parent::$data["title"] = "Dashboard";
        parent::$data["subtitle"] = "dashboard & statistics";
        parent::$data["breadcrumbs"] = ["Dashboard" => ""];
        parent::$data["posts"] = PostModel::Published()->orderby('date','desc')->take(4)->get();
        parent::$data["postsCount"] = PostModel::Published()->count();
        parent::$data["postsViews"] = PostModel::Published()->sum('views');
        parent::$data["inquires"] = InquiryModel::latest()->take(6)->get();
        parent::$data["isDashboard"] = true;

        return view('cp.dashboard.view', parent::$data);
    }
}
