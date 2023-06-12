<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $today = now()->format('Y-m-d');
        return [
            'user_id' => 'required|exists:App\Models\User,id',
            'descricao' => 'required|string|max:191',
            'valor' => 'required|numeric|gte:0',
            'data' => "required|date|before_or_equal:$today",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'gte' => 'O campo :attribute deve ser maior ou igual a 0.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'exists' => 'O campo :attribute deve ser um usuário válido.',
            'date' => 'O campo :attribute deve ser uma data válida.',
            'before_or_equal' => 'O campo :attribute deve ser uma data anterior ou igual a hoje.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => 'usuário',
            'descricao' => 'descrição',
            'valor' => 'valor',
            'data' => 'data',
        ];
    }
}
