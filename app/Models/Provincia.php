<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['nombre'];

    public function municipios() {
        return $this->hasMany(Municipio::class);
    }

    public function miembros()
    {
        return $this->hasManyThrough(
            Miembro::class,
            Municipio::class,
            'provincia_id',  // FK en municipios que apunta a provincias
            'municipio_id',  // FK en miembros que apunta a municipios
            'id',            // PK en provincias
            'id'             // PK en municipios
        );
    }

    // Accessor para contar municipios
    public function getCountMunicipiosAttribute() {
        return $this->municipios()->count();


    }
}
