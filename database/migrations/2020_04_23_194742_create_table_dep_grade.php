<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dep_grade', function (Blueprint $table) {
            $table->integer('position_description_id')->unsigned();
            $table->integer('grade_id')->unsigned();
    
            $table->unique(['position_description_id', 'grade_id']);

            // $table->foreign('position_description_id')->references('id')->on('position_description')
            //     ->onDelete('cascade')->onUpdate('cascade');

            // $table->foreign('grade_id')->references('id')->on('grade')
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
        Schema::dropIfExists('dep_grade');
    }
}
