<?php

namespace App\Http\Requests\Designations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $name_rules = [
            'required',
            'string',
            'max:255',
            Rule::unique("App\Models\Designation", "name")->ignore($this->id)
        ];
        $rules = [
            'name' => $name_rules,
            'detail' => 'nullable',
        ];
        return $rules;


    }
}
