<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Miembro;

class MiembroPolicy
{
    public function viewAny(User $user)
    {
        // Todos pueden ver miembros en el panel
        return true;
    }

    public function view(User $user, Miembro $miembro)
    {
        // Obtener el rol del miembro asociado al usuario
        $userMiembro = $user->miembro;
        $rol = $userMiembro->rol;

        // Mariposa Azul solo puede ver sus miembros referidos directamente
        if ($rol === 'Mariposa Azul') {
            return $miembro->lider_grupo_id === $userMiembro->id;
        }

        // Mariposa Padre/Madre puede ver sus miembros y los de sus referidos
        if ($rol === 'Mariposa Padre/Madre') {
            $referidosIds = $userMiembro->obtenerIdsReferidosDirectos(); // Función hipotética en el modelo Miembro
            return in_array($miembro->lider_grupo_id, $referidosIds);
        }

        // Mariposa Ejecutiva puede ver todos los miembros en su árbol jerárquico
        if ($rol === 'Mariposa Ejecutiva') {
            $todosReferidosIds = $userMiembro->obtenerTodosIdsReferidos(); // Función hipotética en el modelo Miembro
            return in_array($miembro->id, $todosReferidosIds);
        }

        // Por defecto, no se permite ver el miembro
        return false;
    }
}

