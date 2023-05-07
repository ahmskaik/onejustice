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
        $data = $request->data;
        dd($data);
        if ($data) {
            DonationModel::create([
                'email' => $data['email'],
                'gateway' => 'stripe',
                'token' => $data['id'],
                'last4' => $data['card']['last4'],
                'brand' => $data['card']['brand'],
                'amount' => $request->amount,
                'currency' => 'USD',
                'ip' => $data['client_ip'],
                'payload' => json_encode($data)
            ]);
            return response()->json(trans('site.donation_done'));
        }
    }
}
