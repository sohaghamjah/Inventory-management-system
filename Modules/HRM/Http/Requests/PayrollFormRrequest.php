<?php

namespace Modules\HRM\Http\Requests;

use App\Http\Requests\FormRequest;

class PayrollFormRrequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id'     => 'required',
            'employee_id'    => 'required',
            'amount'         => 'required|numeric|gt:0',
            'payment_method' => 'required',
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
