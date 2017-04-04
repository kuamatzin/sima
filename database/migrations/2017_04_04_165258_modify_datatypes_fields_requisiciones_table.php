<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDatatypesFieldsRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->text('lugar_entrega')->change();
            $table->text('requisitos_tecnicos')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->string('lugar_entrega')->change();
            $table->string('requisitos_tecnicos')->change();
        });
    }
}
