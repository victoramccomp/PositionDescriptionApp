<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // PASSWORD RULES        
        // English uppercase characters (A – Z)
        // English lowercase characters (a – z)
        // Base 10 digits (0 – 9)
        // Non-alphanumeric (For example: !, $, #, or %)
        // Unicode characters

        return [
            'name' => 'required',
            'email' => 'required',
            'password' => [
                'required',
                'min:6',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'  // must contain a special character
            ]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo Nome é obrigatório',
            'email.required' => 'O campo E-mail é obrigatório',
            'password.required' => 'O campo Senha é obrigatório',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
            'password.regex' => 'A senha deve conter pelo menos: Um número, uma letra maiúscula, uma letra minúscula, um caractere não-alfanumérico (por exemplo: !, $, #, or %)',
            'password.confirmed' => 'O campo Senha e o campo Confirmação da Senha devem ser iguais!',
        ];
    }
}
