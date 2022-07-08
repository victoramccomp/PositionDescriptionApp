<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGradeCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_course', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->integer('inserted_by')->default(0);

            $table->unsignedBigInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grade');

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
        Schema::dropIfExists('grade_course');
    }
}
