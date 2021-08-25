<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class mailSettingRequest extends FormRequest
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
            'mail_mailer'     => 'required|string',
            'mail_host'       => 'required|string',
            'mail_username'   => 'required|string',
            'mail_password'   => 'required|string',
            'mail_from_name'  => 'required|string',
            'mail_port'       => 'required|integer',
            'mail_encryption' => 'required|string',
        ];
    }
}
