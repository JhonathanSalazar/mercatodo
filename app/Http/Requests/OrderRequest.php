<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'payer_name' => 'required',
            'payer_email' => 'required|email',
            'payer_documentType' => 'required',
            'payer_document' => 'required',
            'payer_phone' => 'required|numeric',
            'payer_address' => 'required',
            'payer_state' => 'required',
            'payer_city' => 'required',
            'payer_postal' => 'required',
        ];
    }
}
