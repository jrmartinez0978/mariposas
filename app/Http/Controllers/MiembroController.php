<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Miembro;

class MiembroController extends Controller
{
    public function asignarRol($miembroId, $roleId)
    {
        $role = Role::find($roleId); // Encuentra el Role basado en el ID
        $miembro = Miembro::find($miembroId); // Encuentra el Miembro basado en el ID

        if ($role && $miembro) {
            $miembro->role()->associate($role); // Asocia el rol al miembro
            $miembro->save(); // Guarda la relación en la base de datos

            return "Rol asignado correctamente.";
        }

        return "Rol o Miembro no encontrado.";
    }
}
