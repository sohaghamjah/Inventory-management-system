<?php

namespace Modules\HRM\Http\Requests;

use App\Http\Requests\FormRequest;

class EmployeeFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['department_id']  = ['required','integer'];
        $rules['name']         = ['required','string'];
        $rules['phone']        = ['required','string','unique:employees,phone'];
        $rules['address']      = ['required','string'];
        $rules['city']         = ['required','string'];
        $rules['state']        = ['required','string'];
        $rules['postal_code']  = ['nullable','string'];
        $rules['country']      = ['required','string'];
        $rules['image']        = ['nullable','image','mimes:jpg,png,jpeg'];

        if(request()->update_id){
            $rules['phone'][2] = 'unique:employees,phone,'.request()->update_id;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'department_id.required' => 'The department field is required',
            'department_id.integer' => 'The department field value must be integer'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
