<?php

namespace App\Http\Requests\CsDetails;

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
            'justification_for_vendor_selection' => 'nullable',
            'cost_center_id' => 'nullable',
            'budget_info' => 'nullable|max:150',
            'delivery_location' => 'nullable|max:250'
        ];
    }
}
