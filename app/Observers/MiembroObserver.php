<?php

namespace App\Observers;

use App\Models\Miembro;

class MiembroObserver
{
    /**
     * Handle the Miembro "created" event.
     */
    public function created(Miembro $miembro): void
    {
        // Llama a actualizarRol en el líder de grupo de este miembro
        $this->actualizarRolLider($miembro);
    }

    /**
     * Handle the Miembro "updated" event.
     */
    public function updated(Miembro $miembro): void
    {
        // Puedes llamar a actualizarRol en el líder de grupo de este miembro si es necesario
        $this->actualizarRolLider($miembro);
    }

    /**
     * Handle the Miembro "deleted" event.
     */
    public function deleted(Miembro $miembro): void
    {
        // Implementa cualquier lógica necesaria cuando un miembro es eliminado
    }

    /**
     * Handle the Miembro "restored" event.
     */
    public function restored(Miembro $miembro): void
    {
        // Implementa cualquier lógica necesaria cuando un miembro es restaurado
    }

    /**
     * Handle the Miembro "force deleted" event.
     */
    public function forceDeleted(Miembro $miembro): void
    {
        // Implementa cualquier lógica necesaria cuando un miembro es eliminado permanentemente
    }

    /**
     * Actualiza el rol del líder de grupo de un miembro.
     */
    protected function actualizarRolLider(Miembro $miembro): void
    {
        $liderGrupo = $miembro->liderGrupo;
        if ($liderGrupo) {
            $liderGrupo->actualizarRol();
            $liderGrupo->save();
        }
    }
}

