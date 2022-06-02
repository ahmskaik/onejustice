<?php

namespace App\Http\Controllers;

use App\Models\DonationModel;
use Illuminate\Http\Request;

class DonateController extends SiteController
{
    public function index(Request $request)
    {
        parent::$data["title"] = trans("site.home") . ' | ' . trans("site.donate");
        return view('site.donate.index', parent::$data);
    }

    public function store(Request $request)
    {
        if ($request->token) {
            DonationModel::create([
                'gateway' => 'stripe',
                'token' => $request->token,
                'amount' => $request->amount,
                'currency' => 'USD',
                'ip' => \Request::ip()
            ]);
            return response()->json(trans('site.donation_done'));
        }
    }
}
