<?php

namespace Modules\Expense\Http\Requests;

use App\Http\Requests\FormRequest;

class ExpenseFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['expense_category_id'] = ['required'];
        $rules['warehouse_id']        = ['required'];
        $rules['account_id']          = ['required'];
        $rules['amount']              = ['required','numeric','gt:0'];
        $rules['note']                = ['nullable','string'];
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
