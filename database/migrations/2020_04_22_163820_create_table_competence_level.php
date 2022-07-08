<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCompetenceLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competence_level', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->integer('inserted_by')->default(0);

            $table->unsignedBigInteger('competence_type_id');
            $table->foreign('competence_type_id')->references('id')->on('competence_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competence_level');
    }
}
