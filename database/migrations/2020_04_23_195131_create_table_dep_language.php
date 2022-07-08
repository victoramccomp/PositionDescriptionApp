<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDepLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dep_language', function (Blueprint $table) {
            $table->integer('position_description_id')->unsigned();
            $table->integer('language_id')->unsigned();
    
            $table->unique(['position_description_id', 'language_id']);

            // $table->foreign('position_description_id')->references('id')->on('position_description')
            //     ->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('language_id')->references('id')->on('language')
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
        Schema::dropIfExists('dep_language');
    }
}
