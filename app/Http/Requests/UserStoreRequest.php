<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends BaseRequest
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
            'email' => 'nullable|unique:users,email',
            'phone_number' => 'nullable|unique:users,phone_number',
            'user_name' => 'required|unique:users,user_name',
            'password' => 'required',
            'name' => 'required'
        ];
    }
}
