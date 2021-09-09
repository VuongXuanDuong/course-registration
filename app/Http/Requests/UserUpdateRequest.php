<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends BaseRequest
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
            'user_name' => 'nullable|unique:users,user_name,' . $this->id . ',id',
            'email' => 'nullable|unique:users,email,' . $this->id . ',id',
            'phone_number' => 'nullable|unique:users,phone_number,'.$this->id.',id',
        ];
    }
}
