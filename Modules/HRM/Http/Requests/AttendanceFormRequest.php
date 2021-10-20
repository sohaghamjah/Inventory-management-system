<?php

namespace Modules\HRM\Http\Requests;

use App\Http\Requests\FormRequest;

class AttendanceFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required',
            'date'        => 'required|date',
            'check_in'    => 'required',
            'check_out'   => 'required',
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
