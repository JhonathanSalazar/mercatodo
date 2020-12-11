<?php

namespace App\Http\Requests;

use App\Constants\PlatformRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole([
            PlatformRoles::ADMIN,
        ]);
    }

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
