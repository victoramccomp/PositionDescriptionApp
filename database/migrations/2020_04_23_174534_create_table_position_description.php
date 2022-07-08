<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePositionDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_description', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('interviewed');
            $table->text('mission');
            $table->integer('experience_time')->default(0);
            $table->integer('leadership_time')->default(0);

            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('position');

            $table->integer('dep_grade_id');
            // area_id
            // grade_course_id
            // grade_requirement
            // grade_status
            
            $table->integer('dep_language_id');
            // language_id
            // language_hability
            // language_level
            // language_requirement
            
            $table->integer('dep_competence_id');
            // competence_id
            // competence_level_id
            // competence_type_id
            // competence_requirement

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
        Schema::dropIfExists('position_description');
    }
}
