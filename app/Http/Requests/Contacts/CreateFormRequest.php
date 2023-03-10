<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
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
            'contact_person' => 'required|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|max:255',
            'position' => 'nullable',
            'is_default' => 'required',
        ];
    }
}
