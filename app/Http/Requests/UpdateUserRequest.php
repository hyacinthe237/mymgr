<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username'      => 'required|min:2',
            'lastname'      => 'required|min:2',
            'firstname'     => 'required|min:2',
            'email'         => 'required|email',
            'mobile'        => 'required|min:8',
            'status'        => 'required|min:2',
        ];
    }
}
