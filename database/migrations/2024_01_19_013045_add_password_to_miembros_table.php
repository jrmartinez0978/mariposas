<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordToMiembrosTable extends Migration
{
    public function up()
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->string('password');
        });
    }

    public function down()
    {
        Schema::table('miembros', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
}
