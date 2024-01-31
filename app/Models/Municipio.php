<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $fillable = ['nombre', 'provincia_id'];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function miembros()
    {
        return $this->hasMany(Miembro::class);
    }
}
