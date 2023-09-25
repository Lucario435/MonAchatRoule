<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     *As you might have guessed, the authorize method is responsible for   *determining if the currently authenticated user can perform the *action represented by the request
     * 
     * 
     * 
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'username' => 'required|max:255|min:2',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:7',
            'password_confirm' => 'required|min:7',
            'email_notification' => 'required|bool',
        ];
    }
}
