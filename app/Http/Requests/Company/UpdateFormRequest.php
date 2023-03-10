<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
            'id' => 'nullable',

            'name' => 'required|max:200',

            'address' => 'nullable|max:250',

            'bin' => 'nullable|max:200',

            'phone_numbers' => 'nullable|max:200',

            'website' => 'nullable|max:200',

            'logo' => 'nullable',

            'cost_centers' => 'required',

        ];
    }
}
