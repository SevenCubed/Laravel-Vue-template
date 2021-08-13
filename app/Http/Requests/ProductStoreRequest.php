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

    protected function prepareForValidation()
    {
        $this->merge([
            'categories' => json_decode($this->categories,true), //convert to array
        ]);
        $this->merge([
            'categories' => $this->categories['categories'], //strip the weird outer array shell
        ]);
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
            'price' => 'required|gte:1',
            'description' => 'min:5',
            'user' => 'required',
            'categories' => 'array|min:1',
        ];
    }
    
    public function messages(){
        return [
            'name.required' => 'A name is required.',
            'name.min' => "A name needs to be at least 5 characters",
            'name.max' => "A name can/'t be more than X characters",
            'description' => "Description pls",
            'price.required' => "A price is required",
            'price.gte' => "The price can't be lower than 1",
            'files.required' => "You must add at least one image",
            'files.image' => "This isn't an image file, chief.",
            'categories.min' => "Please add at least one category",
            'user_id.required' => "Something went wrong, please refresh and try again.",
        ];
    }
}
