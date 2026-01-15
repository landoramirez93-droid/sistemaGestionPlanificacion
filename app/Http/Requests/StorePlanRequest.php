<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // luego conectamos permisos por rol
    }

    public function rules(): array
    {
        return [
            'codigo' => ['nullable','string','max:50'],
            'nombre' => ['required','string','max:255'],

            'descripcion' => ['nullable','string'],

            'fecha_inicio' => ['required','date'],
            'fecha_fin' => ['required','date','after_or_equal:fecha_inicio'],

            'version' => ['nullable','integer','min:1'],
            'estado' => ['nullable', Rule::in(['BORRADOR','EN_REVISION','APROBADO','INACTIVO'])],

            'entidad_id' => ['nullable','integer','exists:entidades,id'],
            'responsable_id' => ['nullable','integer','exists:users,id'],

            // Subcomponentes
            'metas' => ['nullable','array'],
            'metas.*.nombre' => ['required_with:metas','string','max:255'],
            'metas.*.valor_objetivo' => ['nullable','numeric'],
            'metas.*.unidad_medida' => ['nullable','string','max:50'],

            'indicadores' => ['nullable','array'],
            'indicadores.*.nombre' => ['required_with:indicadores','string','max:255'],
            'indicadores.*.meta' => ['nullable','numeric'],

            'cronogramas' => ['nullable','array'],
            'cronogramas.*.actividad' => ['required_with:cronogramas','string','max:255'],
            'cronogramas.*.porcentaje' => ['nullable','integer','min:0','max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_fin.after_or_equal' => 'La fecha fin no puede ser menor que la fecha inicio.',
        ];
    }
}