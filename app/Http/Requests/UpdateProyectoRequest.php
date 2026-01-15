<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // RF-08-03: NO se edita el identificador principal => NO hay 'codigo' aquí
            'nombre' => ['required','string','max:200'],
            'descripcion' => ['nullable','string'],

            'fecha_inicio' => ['required','date'],
            'fecha_fin' => ['required','date','after_or_equal:fecha_inicio'],

            'programa_id' => ['required','integer','exists:programas,id'],

            'estado' => ['required', Rule::in(['PLANIFICADO','EN_EJECUCION','SUSPENDIDO','CERRADO'])],
            'presupuesto' => ['nullable','numeric','min:0'],
        ];
    }
}