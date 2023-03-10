<?php

namespace App\Http\Requests\Requisitions;

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

            'requisition_code' => 'nullable|max:150',
            'item_type' => 'required',

            'cost_center_id' => 'nullable',

            'employee_id' => 'required',

            'application_date' => 'nullable',

            'required_date' => 'nullable',

            'procurement_type' => 'nullable|max:150',

            'budget_info' => 'nullable|max:150',

            'delivery_location' => 'required',
            'contact_person_name_and_number' => 'required',
            'approximate_cost' => 'nullable'
        ];
    }
    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'employee_id.required' => 'Employee field is required',
            'itemData.required' => 'Please select an item',
        ];
    }
}
