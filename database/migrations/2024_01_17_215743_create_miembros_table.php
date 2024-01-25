<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosTable extends Migration
{
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->id('miembros_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni');
            $table->string('provincia');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->boolean('miembros_estado')->default(true);
            $table->unsignedBigInteger('lider_grupo_id')->nullable(); // Quién refirió a este miembro
            $table->string('rol')->default('Mariposa Azul'); // Rol inicial para todos los miembros
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreign('lider_grupo_id')->references('miembros_id')->on('miembros')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('miembros');
    }
}
