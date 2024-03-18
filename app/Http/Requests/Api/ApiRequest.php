<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    protected function failedValidation($validator)
    {

        $firstError = $validator->errors()->first();

        throw new ValidationException(
            $validator,
            new JsonResponse(['error' => [$firstError]], 422)
        );
    }
}
