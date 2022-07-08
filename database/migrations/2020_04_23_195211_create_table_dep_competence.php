<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepCompetence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dep_competence', function (Blueprint $table) {
            $table->integer('position_description_id')->unsigned();
            $table->integer('competence_id')->unsigned();
    
            $table->unique(['position_description_id', 'competence_id']);

            // $table->foreign('position_description_id')->references('id')->on('position_description')
            //     ->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('competence_id')->references('id')->on('competence')
            //     ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dep_competence');
    }
}
