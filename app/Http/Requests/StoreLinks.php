<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// custom rules
use App\Rules\UniqueDependency;

use Illuminate\Support\Str;

class StoreLinks extends FormRequest
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
        $rules =[];
        foreach ($this->all() as $key => $value) {
            // we only need to generate rules for links
            if (Str::startsWith($key, 'link-')) {
                $rules[$key] = [
                    'required',
                    new UniqueDependency('item1_id', $this->entry_id, 'item2_id', $value)
                ];
            }
        };
        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->all() as $key => $value) {
            if (Str::startsWith($key, 'link-')) {
                $messages[$key . 'required'] = [
                    'Select at least one entry to link as a dependency.'
                ];
            }
        };
        return $messages;
    }
}
