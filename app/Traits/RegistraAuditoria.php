<?php

namespace App\Traits;

use App\Models\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait RegistraAuditoria
{
    /**
     * Campos que NO deben registrarse en antes/despues.
     */
    protected array $auditExclude = [
        'password',
        'remember_token',
    ];

    /**
     * Campos que normalmente se ignoran (ruido).
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

    public static function bootRegistraAuditoria(): void
    {
        static::created(function (Model $model) {
            $model->writeAudit('CREAR', null, $model->getAttributes(), 'Registro creado');
        });

        static::updating(function (Model $model) {
            $dirtyKeys = array_keys($model->getDirty());
            $dirtyKeys = array_diff($dirtyKeys, $model->auditIgnore ?? []);

            // Si solo cambian timestamps u otros campos ignorados, no auditar
            if (empty($dirtyKeys)) {
                $model->auditOld = [];
                return;
            }

            $old = array_intersect_key($model->getOriginal(), array_flip($dirtyKeys));
            $model->auditOld = $old;
        });

        static::updated(function (Model $model) {
            $new = $model->getChanges();
            $new = array_diff_key($new, array_flip($model->auditIgnore ?? []));

            if (empty($new)) {
                return;
            }

            $model->writeAudit('ACTUALIZAR', $model->auditOld ?? null, $new, 'Registro actualizado');
        });

        static::deleting(function (Model $model) {
            $model->auditOld = $model->getOriginal();
        });

        static::deleted(function (Model $model) {
            $model->writeAudit('ELIMINAR', $model->auditOld ?? null, null, 'Registro eliminado');
        });
    }

    protected function writeAudit(string $accion, ?array $antes, ?array $despues, ?string $descripcion = null): void
    {
        $antes = $this->filterAuditValues($antes);
        $despues = $this->filterAuditValues($despues);

        $user = Auth::user();

        $payload = [
            'user_id'     => $user?->id,
            'entidad_id'  => $this->resolveEntidadId($user),
            'modulo'      => $this->resolveModuloName(),
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

        // Evita auditoría “fantasma” si hay transacciones que se revierten
        DB::afterCommit(function () use ($payload) {
            Auditoria::create($payload);
        });
    }

    protected function filterAuditValues(?array $values): ?array
    {
        if ($values === null) return null;

        foreach (($this->auditExclude ?? []) as $field) {
            unset($values[$field]);
        }

        return $values;
    }

    protected function resolveModuloName(): string
    {
        // Puedes personalizar esto si quieres nombres más “humanos”
        return class_basename($this);
    }

    protected function resolveEntidadId($user): ?int
    {
        // 1) Si el modelo tiene entidad_id, úsalo
        if (isset($this->attributes['entidad_id'])) {
            return (int) $this->attributes['entidad_id'];
        }

        // 2) Si el usuario tiene entidad_id, úsalo
        if ($user && isset($user->entidad_id)) {
            return (int) $user->entidad_id;
        }

        return null;
    }
}