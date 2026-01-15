<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => [
                'required','string','max:50',
                'regex:/^[A-Z0-9\-_]+$/',
                'unique:proyectos,codigo'
            ],
            'nombre' => ['required','string','max:200'],
            'descripcion' => ['nullable','string'],

            'fecha_inicio' => ['required','date'],
            'fecha_fin' => ['required','date','after_or_equal:fecha_inicio'],

            'programa_id' => ['required','integer','exists:programas,id'],

            'estado' => ['required', Rule::in(['PLANIFICADO','EN_EJECUCION','SUSPENDIDO','CERRADO'])],
            'presupuesto' => ['nullable','numeric','min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.regex' => 'El código solo puede tener letras MAYÚSCULAS, números, guiones y guion bajo.',
        ];
    }
}