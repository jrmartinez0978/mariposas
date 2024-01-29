<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvinciaAndMunicipioReferencesToMiembrosTable extends Migration
{
    public function up()
    {
        Schema::table('miembros', function (Blueprint $table) {
            // Asegúrate de que las columnas 'provincia' y 'municipio' existan y sean del tipo correcto
            $table->foreignId('provincia_id')->nullable()->after('email')->constrained('provincias')->onDelete('set null');
            $table->foreignId('municipio_id')->nullable()->after('provincia_id')->constrained('municipios')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->dropForeign(['provincia_id']);
            $table->dropForeign(['municipio_id']);
            $table->dropColumn('provincia_id');
            $table->dropColumn('municipio_id');
        });
    }
}
