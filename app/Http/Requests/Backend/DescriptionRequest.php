<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class DescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string',
           'product_id' => 'required|exists:products,id',
        ];
    }
    /**
     * Messages personnalisés (optionnel)
     */
    public function messages(): array
    {
        return [
            'content.required' => 'La description du produit est obligatoire.',
            
        ];
    }
}
