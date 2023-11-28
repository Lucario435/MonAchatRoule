<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;


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
        return true;
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => Str::replace(["-","(",")",' '],"",$this->phone),
            
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:75|min:1',
            'surname' => 'required|max:75|min:1',
            'username' => 'required|max:50|min:2|unique:users,username',
            'phone' => 'required|max:10|min:10|unique:users,phone',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(7)],
            'email_notification' => 'digits_between:0,1',
        ];
    }

    public function messages(){
        return[
            'name.required' => 'Le prénom est obligatoire',
            'name.max' => 'Le prénom ne peut pas dépasser 75 caractères',
            'name.min' => 'Le prénom doit aumoins avoir 1 caractère',
            'surname.required' => 'Le nom est obligatoire',
            'surname.max' => 'Le nom ne peut pas dépasser 75 caractères',
            'surname.min' => 'Le surname doit aumoins avoir 1 caractère',
            'username.unique' => 'Le pseudonyme est déjà pris.',
            'username.required' => 'Le pseudonyme est obligatoire',
            'username.min' => 'Le pseudonyme doit être plus de 2 caractères',
            'username.max' => 'Le pseudonyme ne peut pas dépasser 50 caractères',
            'phone.required' => 'Le numéro de téléphone est obligatoire',
            'phone.max' => 'Le numéro de téléphone doit avoir 10 chiffres',
            'phone.min' => 'Le numéro de téléphone doit avoir 10 chiffres',
            'phone.unique' => 'Le numéro de téléphone est déjà pris.',
            'email.required' => 'Le courriel est obligatoire',
            'email.email' => 'Le courriel n\'est obligatoire',
            'email.unique' => 'Le courriel est déjà pris.',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit avoir aumoins 7 caractères',
            'password.confirmed' => 'Le mot de passe ne correspond pas à sa confirmation',

        ];
    }
}
