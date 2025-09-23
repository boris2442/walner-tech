<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
          'email' => 'required|email|max:255',

            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10'

        ];
    }
    /**
     * Messages personnalisés pour la validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',

            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'L’email doit être valide.',
            'email.max' => 'L’email ne peut pas dépasser 255 caractères.',

            'subject.required' => 'Le sujet est obligatoire.',
            'subject.string' => 'Le sujet doit être une chaîne de caractères.',
            'subject.max' => 'Le sujet ne peut pas dépasser 255 caractères.',

            'message.required' => 'Le message est obligatoire.',
            'message.string' => 'Le message doit être une chaîne de caractères.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
        ];
    }

}
