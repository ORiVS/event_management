<?php

namespace App\EventManagement\Users\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required||unique:users',
            'password' => 'required|confirmed',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Le champ email est obligatoire',
            'email.unique' => 'Le champ email est déjà utilisé',
            'password.required' => 'Password is required',
        ];
    }
}
