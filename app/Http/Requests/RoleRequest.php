<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request()->update_id){
            $rules['role_name'] = ['required','string','unique:roles,role_name,'.request()->update_id];
        }else{
            $rules['role_name'] = ['required','string','unique:roles,role_name'];
        }
        return $rules;
    }
}
