<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToken extends FormRequest
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
            'name' => 'required|between:3,40|unique:personal_access_tokens,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Enter the token name.',
            'name.between' => 'Name must be between 3 and 40 characters.',
            'name.unique' => 'A token with this name already exists.'
        ];
    }
}
