<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador',            'descripcion' => 'Acceso total al sistema'],
            ['nombre' => 'Técnico de Planificación', 'descripcion' => 'Gestión técnica de planificación'],
            ['nombre' => 'Revisor Institucional',    'descripcion' => 'Revisión y validación institucional'],
            ['nombre' => 'Auditor',                  'descripcion' => 'Auditoría y control'],
            ['nombre' => 'Usuario Externo',          'descripcion' => 'Acceso limitado para externos'],
            ['nombre' => 'Autoridad Validante',      'descripcion' => 'Aprobación final y validación'],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $rol['nombre']], // evita duplicados
                [
                    'descripcion' => $rol['descripcion'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}