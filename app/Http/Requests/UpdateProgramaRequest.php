<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $programaId = $this->route('programa')?->id ?? $this->route('programa');

        return [
            'nombre' => [
                'required',
                'string',
                'max:180',
                Rule::unique('programas')->ignore($programaId)->where(fn ($q) => $q
                    ->where('fecha_inicio', $this->input('fecha_inicio'))
                    ->where('fecha_fin', $this->input('fecha_fin'))
                    ->whereNull('deleted_at')
                ),
            ],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'responsable_id' => ['nullable', 'integer', 'exists:users,id'],
            'estado' => ['required', 'in:ACTIVO,INACTIVO'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe un programa con el mismo nombre y el mismo periodo.',
        ];
    }
}