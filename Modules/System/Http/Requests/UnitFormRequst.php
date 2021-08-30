<?php

namespace Modules\System\Http\Requests;

use App\Http\Requests\FormRequest;

class UnitFormRequst extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit_name' => 'required|string',
            'unit_code' => 'required|string',
            'base_unit' => 'nullable|integer',
            'operator' => 'nullable|string',
            'operation_value' => 'nullable|string',
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
