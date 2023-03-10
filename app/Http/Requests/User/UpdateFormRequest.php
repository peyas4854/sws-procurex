<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
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
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id= $this->id;

        return [
            'id' => 'required|numeric',

            'employee_id'=>'required',

            'username' =>'required|unique:users,username,'.$id,                        

            'password' => 'nullable|min:8',
            
            'type' => 'required',
         
        ];
    }
}
