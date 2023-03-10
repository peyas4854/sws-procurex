<?php

namespace App\Http\Requests\Employee;

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

            'department_id' => 'nullable',

            'designation_id' => 'nullable',

            'cost_center_id' => 'nullable',

            'code' => 'required|max:100',

            'first_name' => 'required|max:250',

            'middle_name' => 'nullable|max:250',

            'last_name' => 'nullable|max:250',

            'phone' => 'nullable|max:30',

            'email' => 'nullable|max:100',

            'profile_photo' => 'nullable|max:100',

            'status' => 'required'
        ];
    }
}
