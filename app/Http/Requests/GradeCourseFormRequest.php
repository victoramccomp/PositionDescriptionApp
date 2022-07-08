<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GradeCourseFormRequest extends FormRequest
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
            'grade' => 'required',
            'area' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'O campo Curso é obrigatório',
            'grade.required' => 'O campo Grau é obrigatório',
            'area.required' => 'O campo Área é obrigatório'
        ];
    }
}
