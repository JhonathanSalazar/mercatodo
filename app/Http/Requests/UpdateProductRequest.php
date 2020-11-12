<?php

namespace App\Http\Requests;

use App\Concerns\HasProductValidationRules;
use Illuminate\Foundation\Http\FormRequest;


class UpdateProductRequest extends FormRequest
{

    use HasProductValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

}
