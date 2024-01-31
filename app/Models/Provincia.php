<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['nombre'];

    public function municipios() {
        return $this->hasMany(Municipio::class);
    }

    // Accessor para contar municipios
    public function getCountMunicipiosAttribute() {
        return $this->municipios()->count();
    }
}
