<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PermissionUpdateRequest extends FormRequest
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
        $rules['name'] = ['required','string'];
        $rules['slug'] = ['required','string','unique:permissions,slug,'.request()->update_id];
        return $rules;
    }
}
