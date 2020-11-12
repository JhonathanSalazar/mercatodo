<?php


namespace App\Concerns;

use Illuminate\Validation\Rule;

trait HasProductValidationRules
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'ean' => ['required',
                'integer',
                'digits_between:8,14',
                Rule::unique('products')->ignore($this->product)
            ],
            'branch' => 'required',
            'price' => 'required|integer',
            'image' => 'mimes:jpeg,png'
        ];
    }
}
