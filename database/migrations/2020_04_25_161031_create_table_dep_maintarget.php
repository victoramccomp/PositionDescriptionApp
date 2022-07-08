<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepMaintarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dep_maintarget', function (Blueprint $table) {
            $table->integer('position_description_id')->unsigned();
            $table->integer('maintarget_id')->unsigned();
            $table->integer('mainactivity_id')->unsigned();
    
            $table->unique(['position_description_id', 'mainactivity_id']);

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
        Schema::dropIfExists('dep_maintarget');
    }
}
