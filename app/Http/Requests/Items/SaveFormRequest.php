<?php

namespace App\Http\Requests\Items;

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

            'description' => 'nullable|max:250',

            'category_id' => 'nullable',

            'brand_id' => 'nullable',

            'uom_id' => 'nullable',

            'price' => 'nullable',

            'price_date' => 'nullable|max:150',

            'item_type' => 'nullable|max:50',

            'is_active' => 'required'
        ];
    }
}
