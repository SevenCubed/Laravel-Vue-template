<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: Make this not suck
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
            'name' => 'required',
            'files' => 'mimes:jpg,png,jpeg,gif,svg',
            'description' => 'min:5',
        ];
    }
    
    public function messages(){
        return [
            'name.required' => 'A name is required.',
            'name.min' => "A name needs to be at least 5 characters",
            'name.max' => "A name can/'t be more than X characters",
            'description' => "Description pls",
            'price' => "Price pls",
            'files.required' => "You must add at least one image",
            'files.image' => "This isn't an image file, chief.",
        ];
    }
}
