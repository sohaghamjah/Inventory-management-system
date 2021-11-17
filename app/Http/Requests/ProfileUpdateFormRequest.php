<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;     

class ProfileUpdateFormRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'mobile' => 'required|string|max:15|unique:users,mobile,'.auth()->user()->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg',
        ];
    }
}
