<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;

class RegisterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fullName'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ];
    }
}
