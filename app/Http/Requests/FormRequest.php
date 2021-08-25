<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class FormRequest extends LaravelFormRequest
{
    abstract public function rules();
    
    abstract public function authorize();

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException( 
            response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ])
        );
    }

}
