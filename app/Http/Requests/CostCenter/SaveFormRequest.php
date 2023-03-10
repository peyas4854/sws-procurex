<?php

namespace App\Http\Requests\CostCenter;

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
        return [
            'name' => 'required|max:150',
            'cost_center_code' => 'nullable|max:100',
            'description' => 'nullable|max:250',
            'buHeads' => 'nullable',
            'finance_ids' => 'nullable',
        ];
    }
}
