<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePositionInterest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_interest', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('CPF');

            $table->unsignedBigInteger('dep_id');
            $table->foreign('dep_id')->references('id')->on('position_description');

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
        Schema::dropIfExists('position_interest');
    }
}
