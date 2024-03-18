<?php

namespace App\Http\Requests\Api;


class StoreCapsuleRequest extends ApiRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'message' => 'required|string',
            'openeingTime' => 'required|date_format:Y-m-d H:i:s|after:today',
        ];
    }
}
