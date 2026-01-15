<?php

namespace App\Models;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos permitidos para asignación masiva (mass assignment).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * Relación: un usuario pertenece a un rol.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Verifica si el usuario tiene uno de los roles indicados.
     *
     * @param string|array $roles  Rol o lista de roles aceptados.
     * @return bool               True si el rol del usuario coincide con alguno.
     */
    public function hasRole(string|array $roles): bool
    {
        // Obtiene el nombre del rol del usuario de forma segura (evita error si no hay rol)
        $userRole = $this->rol?->nombre;

        // Si no existe rol asignado, no cumple
        if (!$userRole) {
            return false;
        }

        // Convierte a array si viene un string (para manejar ambos casos)
        $roles = Arr::wrap($roles);

        // Compara de forma estricta (tipo y valor)
        return in_array($userRole, $roles, true);
    }

    /**
     * Atajo: indica si el usuario es Administrador.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Administrador');
    }

    /**
     * Atajo: indica si el usuario es Técnico de Planificación.
     */
    public function isTecnicoPlanificacion(): bool
    {
        return $this->hasRole('Tecnico de Planificacion');
    }

    /**
     * Atributos ocultos al serializar (por seguridad).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversiones (casts) automáticas de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convierte a fecha/hora
            'password' => 'hashed',            // Hashea automáticamente al asignar
        ];
    }
}