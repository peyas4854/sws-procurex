<?php

namespace App\Http\Requests\Vendors;

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
            'vendor_code' => 'required|max:100|unique:App\Models\Vendor,vendor_code,'.$this->id,
            'name' => 'required|max:200',
            'address' => 'nullable|max:250',
            'office_phone' => 'nullable|max:30',
            'office_email' => 'nullable|max:100',
            'bin' => 'nullable|max:100',
            'tin' => 'nullable|max:100',
            'trade_license' => 'nullable|max:100',
            'bank_account_name' => 'nullable|max:100',
            'bank_account_number' => 'nullable|max:100',
            'bank_routing_number' => 'nullable|max:100',
            'bank_name' => 'nullable|max:100',
            'bank_branch' => 'nullable|max:100',
            'status' => 'required'
        ];
    }
}
