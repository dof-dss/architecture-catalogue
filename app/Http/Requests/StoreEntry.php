<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// custom rules
use App\Rules\UniqueComposite;

class StoreEntry extends FormRequest
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
            'name' => [
                'required',
                'between:3,40',
                new UniqueComposite('entries', 'name', $this->name, 'version', $this->version, $this->id)
            ],
            'version' => [
                'nullable',
                'alpha_numeric_spaces_punctuation',
                'between:1,20',
                new UniqueComposite('entries', 'version', $this->version, 'name', $this->name, $this->id)
            ],
            'href' => 'nullable|custom_url|max:250',
            'description' => 'required|alpha_numeric_spaces_punctuation|between:3,100',
            'category_subcategory' => 'required|alpha_numeric_spaces_punctuation|between:8,80',
            'status' => 'required|alpha|max:10',
            'functionality' => 'nullable|string|max:300',
            'service_levels' => 'nullable|string|max:300',
            'interfaces' => 'nullable|string|max:300',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Enter the component name.',
            'name.alpha_numeric_spaces' => 'Name must only include letters, digits and spaces.',
            'name.between' => 'Name must be between 3 and 40 characters.',
            'version.required' => 'Enter a version.',
            'version.alpha_numeric_spaces_punctuation' => 'Version must only include letters, digits, spaces and punctuation.',
            'version.between' => 'Version must be between 1 and 20 characters.',
            'href.url' => 'The URL is invalid.',
            'href.custom_url' => 'The URL is invalid.',
            'href.max' => 'The associated URL must be 250 characters or fewer.',
            'description.required' => 'Enter a description.',
            'description.alpha_numeric_spaces' => 'Description must only include letters, digits and spaces.',
            'description.alpha_numeric_spaces_punctuation' => 'Description must only include letters, digits, spaces and punctuation.',
            'description.between' => 'Description must be between 3 and 100 characters.',
            'category_subcategory.required' => 'Enter a category and subcategory.',
            'category_subcategory.alpha_numeric_spaces_punctuation' => 'Category and subcategory must only include letters, digits, spaces and punctuation.',
            'category_subcategory.between' => 'Category and subcategory must be between 8 and 80 characters.',
            'status.required' => 'Enter a status.',
            'status.alpha' => 'Status must only include letters.',
            'status.max' => 'Status must be 10 characters or fewer.',
            'functionality.string' => 'Supported functionality must be string of characters.',
            'functionality.max' => 'Supported functionality must 300 characters or fewer.',
            'service_levels.string' => 'Service levels must be string of characters.',
            'service_levels.max' => 'Service levels must be 300 characters or fewer.',
            'interfaces.string' => 'Interfaces must must be string of characters.',
            'interfaces.max' => 'Interfaces must be 300 characters or fewer.',
        ];
    }
}
