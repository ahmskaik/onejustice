<?php

namespace App\Http\Controllers\Admin;


use App\Models\SystemLookupModel;
use App\Models\SystemUserModel;
use Auth;
use Cookie;
use Hash;
use Illuminate\Http\Request;
use Session;

class LoginController extends SuperAdminController
{
    public function index()
    {
        if (!Auth::check()) {
            if (Session::has("error"))
                parent::$data["error"] = Session::get("error");
            return view("cp.login", parent::$data);
        } else {
            return redirect(parent::$data['cp_route_name']);
        }
    }

    public function check(Request $request)
    {
        if (!Auth::check()) {
            $username = xss_clean($request->input("user_name"));
            $password = xss_clean($request->input("password"));
            $status = SystemLookupModel::getIdByKey("SYSTEM_USER_STATUS_ACTIVE");

            $attempt = ['user_name' => $username, 'password' => $password, 'status' => $status];

            if (!filter_var($username, FILTER_VALIDATE_EMAIL) === false) {
                $attempt2 = ['email' => $username, 'password' => $password, 'status' => $status];
            }


            if (Auth::attempt($attempt, true) || (isset($attempt2) && Auth::attempt($attempt2, true))) {

                $SysUsr_ID = Auth::user()->id;
                $SysUsr_LastLoginDate = date('Y-m-d H:i:s');
                $SysUsr_LastIPAddress = $_SERVER["REMOTE_ADDR"];

                SystemUserModel::updateLoginInfo($SysUsr_ID, $SysUsr_LastLoginDate, $SysUsr_LastIPAddress);

                Cookie::queue(Cookie::forget('relogin'));

                return redirect()->intended(parent::$data['cp_route_name']);
            } else {
                if (Cookie::get('relogin'))
                    return redirect(parent::$data['cp_route_name'] . "/relogin")->with("error", "Check your password");

                return redirect(parent::$data['cp_route_name'] . "/login")->with("error", "Check your username and password");
            }
        } else {
            return redirect(parent::$data['cp_route_name']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(parent::$data['cp_route_name'] . "/login");
    }

    public function lock()
    {
        $user = Auth::user("admin");
        Cookie::queue("relogin", $user->id, 99999);

        Auth::logout('admin');
        return redirect(parent::$data['cp_route_name'] . "/relogin");
    }

    public function relogin()
    {
        if (!Auth::check() && Cookie::get('relogin')) {
            if (Session::has("error"))
                parent::$data["error"] = Session::get("error");

            parent::$data["user"] = SystemUserModel::find(Cookie::get('relogin'));


            if (!parent::$data["user"])
                return redirect(parent::$data['cp_route_name'] . "/login");
            return view("cp.lock", parent::$data);
        } else {
            return redirect(parent::$data['cp_route_name']);
        }
    }
}
