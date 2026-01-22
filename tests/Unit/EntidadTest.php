<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Entidad;

class EntidadTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_entidad(): void
    {
        $entidad = Entidad::create([
            'nombre' => 'Entidad demo',
            'sigla'  => 'EDMO', // 👈 OBLIGATORIO
        ]);

        $this->assertDatabaseHas('entidades', [
            'id'     => $entidad->id,
            'nombre' => 'Entidad demo',
            'sigla'  => 'EDMO',
        ]);
    }
}