<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Miembro extends Model
{
    protected $table = 'miembros';
    protected $primaryKey = 'miembros_id';
    protected $fillable = [
        'nombres',
        'apellidos',
        'cedula',   // Cambiado de 'dni' a 'cedula'
        'provincia',
        'email',
        'telefono',
        'estado',   // Cambiado de 'miembros_estado' a 'estado'
        'lider_grupo_id',
        'rol',
        'municipio'   // Nueva columna 'municipio'
    ];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    /** creacion miembro */

    protected static function booted()
{
    static::creating(function ($miembro) {
        // Generar una contraseña segura
        $simbolos = ['@', '#', '$', '%', '&'];
        $password = Str::random(3) . rand(100, 999) . $simbolos[array_rand($simbolos)];


        // Almacenar la contraseña en texto plano en el modelo, no es ideal por razones de seguridad
        // Considera enviar esta contraseña por correo electrónico o usar un enlace de restablecimiento de contraseña
        $miembro->password = $password;
    });

    static::created(function ($miembro) {
        // Crear un usuario asociado con este miembro
        $user = User::create([
            'name' => $miembro->nombres . ' ' . $miembro->apellidos,
            'email' => $miembro->email,
            'password' => Hash::make($miembro->password),
        ]);

        // Asignar el ID del usuario al miembro
        $miembro->user_id = $user->id;
        $miembro->save();
        });

        static::updated(function ($miembro) {
            if ($miembro->user) {
                if ($miembro->wasChanged('email')) {
                    $miembro->user->email = $miembro->email;
                }
                if ($miembro->wasChanged('password')) {
                    $miembro->user->password = Hash::make($miembro->password);
                }
                $miembro->user->save();
            }
        });

        static::deleting(function ($miembro) {
            // Verifica si el miembro tiene un usuario asociado y elimínalo
            if ($miembro->user) {
                $miembro->user->delete();
            }
        });
    }

    public function liderGrupo()
    {
        return $this->belongsTo(Miembro::class, 'lider_grupo_id', 'miembros_id');
    }

    // Accesor para obtener el nombre completo del líder de grupo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function miembrosReferidos()
    {
        return $this->hasMany(Miembro::class, 'lider_grupo_id', 'miembros_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actualizarRol()
{
    $cantidadMiembrosReferidos = $this->miembrosReferidos()->count();

    // Actualizar a 'Mariposa Madre' si se cumplen las condiciones
    if ($cantidadMiembrosReferidos >= 3 && $this->rol === 'Mariposa Azul') {
        $this->rol = 'Mariposa Padre/Madre';
    }
    // Actualizar a 'Mariposa Reina' si se cumplen las condiciones
    elseif ($this->rol === 'Mariposa Padre/Madre' && $this->todosReferidosTienenDiezReferidos()) {
        $this->rol = 'Mariposa Ejecutiva';
    }
    // Degradar a 'Mariposa Azul' si no se cumple el mínimo de referido
    elseif ($cantidadMiembrosReferidos < 3 && $this->rol === 'Mariposa Padre/Madre') {
        $this->rol = 'Mariposa Azul';
    }
    // Degradar a 'Mariposa Madre' si los referidos ya no cumplen las condiciones para ser 'Mariposa Reina'
    elseif ($this->rol === 'Mariposa Ejecutiva' && !$this->todosReferidosTienenDiezReferidos()) {
        $this->rol = 'Mariposa Padre/Madre';
    }

    $this->save();
}

private function todosReferidosTienenDiezReferidos()
{
    foreach ($this->miembrosReferidos as $referido) {
        if ($referido->miembrosReferidos()->count() < 3) {
            return false;
        }
    }
    return true;
    }
}
