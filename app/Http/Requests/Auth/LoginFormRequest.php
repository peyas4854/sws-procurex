<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
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
            "identity" => "required|string|max:50",
            "password" => "required",
            "remember" => "nullable|in:0,1"
        ];
    }
    public function messages()
    {
        return [
            "identity.required" => "Email or username field is required",
        ];
    }
}
