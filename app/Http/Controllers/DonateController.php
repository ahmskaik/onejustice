<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonateController extends SiteController
{
    public function index(Request $request)
    {
        parent::$data["title"] = trans("site.home") . ' | ' . trans("site.donate");
        return view('site.donate.index', parent::$data);
    }
}
