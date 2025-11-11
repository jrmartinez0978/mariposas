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
        // Validar que el usuario tenga un miembro asociado
        if (!$user->miembro) {
            return false;
        }

        // Obtener el rol del miembro asociado al usuario
        $userMiembro = $user->miembro;
        $rol = $userMiembro->rol;

        // Mariposa Azul solo puede ver sus miembros referidos directamente
        if ($rol === 'Mariposa Azul') {
            return $miembro->lider_grupo_id === $userMiembro->miembros_id;
        }

        // Mariposa Padre/Madre puede ver sus miembros y los de sus referidos (2 niveles)
        if ($rol === 'Mariposa Padre/Madre') {
            // Puede ver sus referidos directos
            if ($miembro->lider_grupo_id === $userMiembro->miembros_id) {
                return true;
            }

            // Puede ver los referidos de sus referidos
            $referidosDirectosIds = $userMiembro->obtenerIdsReferidosDirectos();
            return in_array($miembro->lider_grupo_id, $referidosDirectosIds->toArray());
        }

        // Mariposa Ejecutiva puede ver todos los miembros en su árbol jerárquico
        if ($rol === 'Mariposa Ejecutiva') {
            $todosReferidosIds = $userMiembro->obtenerTodosIdsReferidos();
            return in_array($miembro->miembros_id, $todosReferidosIds->toArray());
        }

        // Por defecto, no se permite ver el miembro
        return false;
    }
}

