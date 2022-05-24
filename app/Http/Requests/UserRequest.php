<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $user_id = $this->segment(4);
        if ($this->segment(3) == "updateProfile") {
            $user_id = Auth::user("admin")->id;
        }

        $response = [
            "full_name" => "required",
            "dob" => "nullable|date",
            "roleid" => "required",
            "action" => "array|required"
        ];

        //create
        if (!$this->segment(4) && $this->segment(3) != "updateProfile") {
            $response["password"] = "required|confirmed|min:6";
            $response["password_confirmation"] = "required";
            $response["user_name"] = "required|unique:system_users,user_name,NULL,id,deleted_at,NULL";
            $response["email"] = "required|email|unique:system_users,email,NULL,id,deleted_at,NULL";
        } else {
            //update
            $response["user_name"] = "required|unique:system_users,user_name," . $user_id . ",id,deleted_at,NULL";
            $response["email"] = "required|email|unique:system_users,email," . $user_id . ",id,deleted_at,NULL";
        }

        if ($this->segment(3) == "updateProfile") {
            unset($response['roleid']);
            unset($response['action']);
        }

        return $response;
        // return Response::json($response, 400);
    }

    public function messages()
    {
        return [
            "array" => "Check at least on permission",
            'required' => 'This field is required!',
            'action.required' => 'At least add one permission!',
            'email.unique' => 'Email is alrady exist!',
            'user_name.unique' => 'Username is alrady exist!',
        ];
    }
}
