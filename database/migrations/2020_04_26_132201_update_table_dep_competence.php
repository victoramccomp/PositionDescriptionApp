<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDepCompetence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dep_competence', function (Blueprint $table) {
            $table->string('level');
            $table->string('requirement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dep_competence', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('requirement');
        });
    }
}
