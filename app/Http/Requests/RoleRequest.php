<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->segment(4)) {

            $rule = "required|unique:roles,name," . $this->segment(4) . ',id,deleted_at,NULL';
        } else {

            $rule = "required|unique:roles,name,NULL,id,deleted_at,NULL";
        }
        return [
            "name" => $rule,
            "action" => "array|required"
        ];
    }

    public function messages()
    {
        return [
            "array" => "Check at least on permission",
            'action.required' => 'At least add one permission!'
        ];
    }
}
