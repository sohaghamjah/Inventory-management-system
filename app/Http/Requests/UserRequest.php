<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class UserRequest extends FormRequest
{
    protected $rules = [];
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
        $this->rules['name'] = ['required','string'];
        $this->rules['email'] = ['required','string','email','unique:users,email'];
        $this->rules['mobile'] = ['required','string','max:15','unique:users,mobile'];
        $this->rules['gender'] = ['required','integer'];
        $this->rules['role_id'] = ['required','integer'];
        $this->rules['password'] = ['required','string','min:8','confirmed'];
        $this->rules['password_confirmation'] = ['required','string','min:8'];
        if(request()->update_id){
            $this->rules['email'][3] = 'unique:users,email,'.request()->update_id;
            $this->rules['mobile'][3] = 'unique:users,mobile,'.request()->update_id;
            $this->rules['password'][0] = 'nullable';
            $this->rules['password_confirmation'][0] = 'nullable';
        }
        return $this->rules;
    }
}
