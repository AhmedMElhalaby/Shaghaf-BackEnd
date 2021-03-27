<?php

namespace App\Http\Requests\Api;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    use ResponseTrait;
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->failJsonResponse($validator->errors()->all()));
    }
}
