<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;


class MenuRequest extends FormRequest
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
            $rules['menu_name'] = ['required','string','unique:menus,menu_name,'.request()->update_id];
        }else{
            $rules['menu_name'] = ['required','string','unique:menus,menu_name'];
        }
        $rules['deletable'] = ['required','integer'];
        return $rules;
    }
}
