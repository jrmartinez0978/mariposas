<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRedundantColumnsFromMiembrosTable extends Migration
{
    public function up()
    {
        Schema::table('miembros', function (Blueprint $table) {
            if (Schema::hasColumn('miembros', 'provincia')) {
                $table->dropColumn('provincia');
            }
            if (Schema::hasColumn('miembros', 'municipio')) {
                $table->dropColumn('municipio');
            }
        });
    }

    public function down()
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->string('provincia')->nullable()->after('cedula');
            $table->string('municipio')->nullable()->after('provincia_id');
        });
    }
}
