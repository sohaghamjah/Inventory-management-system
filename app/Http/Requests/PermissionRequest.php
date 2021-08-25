<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class PermissionRequest extends FormRequest
{
    protected $rules = [];
    protected $messages = [];
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
        $this->rules['module_id'] = ['required', 'integer'];
        $this->messages['module_id.required'] = 'This module field is required';
        $this->messages['module_id.integer'] = 'This module field is must be integer';

        $collection = collect(request());

        if($collection->has('permission')){
            foreach(request() -> permission as $key => $value){
                $this->rules['permission.'.$key.'.name'] = ['required', 'string'];
                $this->rules['permission.'.$key.'.slug'] = ['required', 'string', 'unique:permissions,slug'];

                $this->messages['permission.'.$key.'.name.required'] = 'The name field is requires';
                $this->messages['permission.'.$key.'.name.string'] = 'The name field is must be string';
                $this->messages['permission.'.$key.'.slug.required'] = 'The slug field is required';
                $this->messages['permission.'.$key.'.slug.string'] = 'The slug field is must be string';
                $this->messages['permission.'.$key.'.slug.unique'] = 'The slug field has already been taken';
            }
        }

        return $this->rules;
    }

    public function messages(){
        return $this->messages;
    }
}
