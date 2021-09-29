<?php

namespace Modules\Purchase\Http\Requests;

use App\Http\Requests\FormRequest;

class PurchasePaymentFormRequst extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['paying_amount'] = ['required','numeric','gt:0'];
        $rules['amount'] = ['required','numeric','gt:0'];
        
        if(request()->amount > request()->paying_amount)
        {
            $rules['amount'][3]='lte:paying_amount';
        }
        if(empty(request()->payment_id)){
            $rules['balance'] = ['numeric','gt:0'];
            if(request()->amount > request()->balance)
            {
                $rules['amount'][3]='lte:balance';
            }
        }
        $rules['payment_method']  = ['required'];
        $rules['account_id']      = ['required'];
        if(!empty(request()->payment_method)){
            if(request()->payment_method != 1){
                $rules['payment_no'] = ['required'];
            }
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
