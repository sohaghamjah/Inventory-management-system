<?php

namespace Modules\System\Http\Requests;

use App\Http\Requests\FormRequest;

class CustomerGroupFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['group_name'] = ['required','string','unique:customer_groups,group_name'];
        $rules['percentage'] = ['nullable','numeric'];
        if(request()->update_id){
            $rules['group_name'][2] = 'unique:customer_groups,group_name,'.request()->update_id;
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
