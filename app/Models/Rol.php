<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = ['nombre', 'descripcion'];

     /**
     * Relación: un Rol tiene muchos usuarios.
     * - hasMany indica que varios registros de users apuntan a este rol.
     * - 'rol_id' es la llave foránea en la tabla users que referencia a roles.id
     */
    public function users()
    {
    return $this->hasMany(User::class, 'rol_id');
    }
}