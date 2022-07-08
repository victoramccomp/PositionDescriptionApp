<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompetenceLevelFormRequest extends FormRequest
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
        return [
            'description' => 'required',
            'competence_type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'O campo Nível de Competência é obrigatório',
            'competence_type.required' => 'O campo Tipo de Competência é obrigatório',
        ];
    }
}
