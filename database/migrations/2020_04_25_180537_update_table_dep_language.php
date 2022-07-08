<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDepLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dep_language', function (Blueprint $table) {
            $table->string('skill')->nullable();
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
        Schema::table('dep_language', function (Blueprint $table) {
            $table->dropColumn('skill');
            $table->dropColumn('level');
            $table->dropColumn('requirement');
        });
    }
}
