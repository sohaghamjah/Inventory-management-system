<?php

namespace Modules\Supplier\Http\Requests;

use App\Http\Requests\FormRequest;

class SupplierFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['name']            = ['required','string'];
        $rules['company_name']    = ['nullable','string'];
        $rules['vat_number']      = ['nullable','string'];
        $rules['phone']           = ['nullable','string','unique:suppliers,phone'];
        $rules['email']           = ['nullable','email','unique:suppliers,email'];
        $rules['address']         = ['nullable','string'];
        $rules['city']            = ['nullable','string'];
        $rules['state']           = ['nullable','string'];
        $rules['postal_code']     = ['nullable','string'];
        $rules['country']         = ['nullable','string'];

        if(request()->update_id){
            $rules['phone'][2] ='unique:suppliers,phone,'.request()->update_id;
            $rules['email'][2] = 'unique:suppliers,email,'.request()->update_id;
        }
        return $rules;
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
