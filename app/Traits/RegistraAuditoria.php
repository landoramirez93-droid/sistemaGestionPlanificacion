<?php

namespace App\Traits;

use App\Models\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait RegistraAuditoria
{
    /**
     * Campos sensibles que nunca deben persistirse en auditoría.
     */
    protected array $auditExclude = [
        'password',
        'remember_token',
    ];

    /**
     * Campos “ruido” que no aportan al antes/después.
     */
    protected array $auditIgnore = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * Almacén temporal de valores "antes" para updates/deletes.
     */
    protected array $auditOld = [];

    /**
     * Hook automático cuando el trait se usa en un Modelo Eloquent.
     */
    public static function bootRegistraAuditoria(): void
    {
        static::created(function (Model $model) {
            $model->writeAudit(
                accion: 'CREAR',
                antes: null,
                despues: $model->getAttributes(),
                descripcion: $model->auditDescripcion('CREAR', null, $model->getAttributes())
                    ?? 'Registro creado'
            );
        });

        static::updating(function (Model $model) {
            $dirtyKeys = array_keys($model->getDirty());
            $dirtyKeys = array_values(array_diff($dirtyKeys, $model->getAuditIgnore()));

            // Si solo cambian campos ignorados, no auditar
            if (empty($dirtyKeys)) {
                $model->auditOld = [];
                return;
            }

            $model->auditOld = array_intersect_key(
                $model->getOriginal(),
                array_flip($dirtyKeys)
            );
        });

        static::updated(function (Model $model) {
            $new = $model->getChanges();
            $new = array_diff_key($new, array_flip($model->getAuditIgnore()));

            if (empty($new)) {
                return;
            }

            $descripcion = $model->auditDescripcion('ACTUALIZAR', $model->auditOld ?? null, $new)
                ?? 'Registro actualizado';

            $model->writeAudit('ACTUALIZAR', $model->auditOld ?? null, $new, $descripcion);
        });

        static::deleting(function (Model $model) {
            $model->auditOld = $model->getOriginal();
        });

        static::deleted(function (Model $model) {
            $descripcion = $model->auditDescripcion('ELIMINAR', $model->auditOld ?? null, null)
                ?? 'Registro eliminado';

            $model->writeAudit('ELIMINAR', $model->auditOld ?? null, null, $descripcion);
        });
    }

    /**
     * Punto de extensión: personaliza el módulo (por defecto, nombre de clase).
     */
    protected function auditModulo(): string
    {
        return class_basename($this);
    }

    /**
     * Punto de extensión: personaliza la descripción por acción.
     * Retorna null para usar descripciones por defecto.
     */
    protected function auditDescripcion(string $accion, ?array $antes, ?array $despues): ?string
    {
        return null;
    }

    /**
     * Permite a modelos sobrescribir estos campos si lo requieren.
     */
    protected function getAuditExclude(): array
    {
        return $this->auditExclude ?? [];
    }

    protected function getAuditIgnore(): array
    {
        return $this->auditIgnore ?? [];
    }

    protected function writeAudit(string $accion, ?array $antes, ?array $despues, ?string $descripcion = null): void
    {
        $antes = $this->filterAuditValues($antes);
        $despues = $this->filterAuditValues($despues);

        $user = Auth::user();

        $payload = [
            'user_id'     => $user?->id,
            'entidad_id'  => $this->resolveEntidadId($user),
            'modulo'      => $this->auditModulo(),
            'accion'      => $accion,
            'tabla'       => $this->getTable(),
            'registro_id' => $this->getKey(),
            'descripcion' => $descripcion,
            'antes'       => $antes,
            'despues'     => $despues,
            'url'         => app()->runningInConsole() ? null : request()->fullUrl(),
            'metodo'      => app()->runningInConsole() ? null : request()->method(),
            'ip'          => app()->runningInConsole() ? null : request()->ip(),
            'user_agent'  => app()->runningInConsole() ? null : request()->userAgent(),
        ];

        // Evita auditoría “fantasma” si la transacción se revierte
        DB::afterCommit(function () use ($payload) {
            Auditoria::create($payload);
        });
    }

    protected function filterAuditValues(?array $values): ?array
    {
        if ($values === null) {
            return null;
        }

        // Quita ruido
        foreach ($this->getAuditIgnore() as $field) {
            unset($values[$field]);
        }

        // Quita sensibles
        foreach ($this->getAuditExclude() as $field) {
            unset($values[$field]);
        }

        return $values;
    }

    protected function resolveEntidadId($user): ?int
    {
        // 1) Si el modelo tiene entidad_id, úsalo
        if (array_key_exists('entidad_id', $this->attributes ?? [])) {
            return $this->attributes['entidad_id'] !== null ? (int) $this->attributes['entidad_id'] : null;
        }

        // 2) Si el usuario tiene entidad_id, úsalo
        if ($user && isset($user->entidad_id)) {
            return (int) $user->entidad_id;
        }

        return null;
    }
}