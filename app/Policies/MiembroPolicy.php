<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Miembro;
use App\Policies\create;

class MiembroPolicy
{
    public function viewAny(User $user)
    {
        // Todos pueden ver miembros en el panel
        return true;
    }

    public function view(User $user, Miembro $miembro)
    {
        // Mariposa Azul solo puede ver sus miembros referidos
        if ($user->miembro->rol === 'Mariposa Azul') {
            return $miembro->lider_grupo_id === $user->miembro->id;
        }

        // Mariposa Padre/Madre puede ver sus miembros y los de sus referidos
        if ($user->miembro->rol === 'Mariposa Padre/Madre') {
            return $miembro->lider_grupo_id === $user->miembro->id ||
                   $miembro->liderGrupo->lider_grupo_id === $user->miembro->id;
        }

        /// Mariposa Ejecutiva puede ver sus referidos y los referidos de sus referidos
    if ($user->miembro->rol === 'Mariposa Ejecutiva') {
        return $this->esReferidoDeMariposaEjecutiva($user->miembro, $miembro);
    }

    return false;
}

/**
 * Determina si un miembro es referido directo o indirecto de una Mariposa Ejecutiva.
 *
 * @param  \App\Models\Miembro  $mariposaEjecutiva
 * @param  \App\Models\Miembro  $miembro
 * @return bool
 */
private function esReferidoDeMariposaEjecutiva(Miembro $mariposaEjecutiva, Miembro $miembro)
{
    // Un miembro no puede ser referido de sí mismo
    if ($mariposaEjecutiva->id === $miembro->id) {
        return false;
    }

    // Comprobar si el miembro es un referido directo
    if ($miembro->lider_grupo_id === $mariposaEjecutiva->id) {
        return true;
    }

    // Comprobar si el miembro es un referido indirecto (a través de otros referidos)
    $referido = $miembro->liderGrupo;
    while ($referido) {
        if ($referido->id === $mariposaEjecutiva->id) {
            return true;
        }
        $referido = $referido->liderGrupo;
    }

    return false;
    }
}
