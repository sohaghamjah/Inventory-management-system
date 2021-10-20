<?php

namespace Modules\Sale\Http\Requests;

use App\Http\Requests\FormRequest;

class SaleFormRequst extends FormRequest
{
    protected $rules;
    protected $messages;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->rules['warehouse_id']    = ['required'];
        $this->rules['customer_id']     = ['required'];
        $this->rules['sale_status']     = ['required'];

        if(request()->sale_status == 1 && empty(request()->sale_id))
        {
            $this->rules['payment_status']     = ['required'];
            if(request()->payment_status != 3)
            {
                $this->rules['paying_amount']     = ['required','numeric','gt:0'];
                $this->rules['paid_amount']       = ['required','numeric','gt:0'];
                $this->rules['payment_method']     = ['required'];
                $this->rules['account_id']     = ['required'];
                if(request()->payment_method == 2 || request()->payment_method == 3)
                {
                    $this->rules['payment_no']     = ['required'];
                }
            }
        }

        if(request()->has('products'))
        {
            foreach (request()->products as $key => $value) {
                $this->rules   ['products.'.$key.'.qty']          = ['required','numeric','gt:0','lte:'.$value['stock_qty']];
                $this->messages['products.'.$key.'.qty.required'] = 'This field is required';
                $this->messages['products.'.$key.'.qty.numeric']  = 'The value must be numeric';
                $this->messages['products.'.$key.'.qty.gt']       = 'The value must be greater than 0';
                $this->messages['products.'.$key.'.qty.lte']       = 'The value must be less than or eqaul to stock qty '.$value['stock_qty'];
            }
        }
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages;
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
