<?php

namespace App\Http\Requests\ApprovalTeams;

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

            'employee_ids' => 'nullable',

            'detail' => 'nullable|max:250'
        ];
    }
}
