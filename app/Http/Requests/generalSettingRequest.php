<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class generalSettingRequest extends FormRequest
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
        return [
            'title'             => 'required|string',
            'address'           => 'required|string',
            'currency_code'     => 'required|string',
            'currency_symbol'     =>'required|string',
            'currency_position' => 'required|string',
            'timezone'          => 'string',
            'date_format'       => 'string',
            'invoice_prefix'    => 'required|string',
            'invoice_number'    => 'required|string',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'favicon'           => 'nullable|image|mimes:png,ico',
        ];
    }
}
