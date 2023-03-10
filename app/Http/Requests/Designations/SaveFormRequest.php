<?php

namespace App\Http\Requests\Designations;

use Illuminate\Foundation\Http\FormRequest;

class SaveFormRequest extends FormRequest
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
        $rules = [
            'name'=> 'required|string|max:255|unique:App\Models\Designation,name', 
            'detail'=> 'nullable',
        ];
        return $rules;
    }
}
