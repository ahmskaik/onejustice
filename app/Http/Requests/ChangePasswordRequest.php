<?php

namespace App\Http\Requests;

class ChangePasswordRequest extends SuperAdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "password" => "required|confirmed|min:6",
            "password_confirmation" => "required",
            "id" => "required|exists:system_users,id"
        ];
    }
}
