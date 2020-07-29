<?php

namespace App\Http\Requests;

use App\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => 'required',
            'description' => 'required',
            'ean' => 'required|integer|digits_between:8,14',
            'branch' => 'required',
            'price' => 'required|integer',
            'image' => [
                'required',
                'mimes:jpeg,png',
            ]
        ];

        if($this->route('product')->image != null)
        {
            $rules['image'] = 'mimes:jpeg,png';
        }

        return $rules;

    }
}
