<?php

namespace Database\Factories;

use App\Models\Entidad;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntidadFactory extends Factory
{
    protected $model = Entidad::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'sigla'  => strtoupper($this->faker->lexify('???')),
        ];
    }
}