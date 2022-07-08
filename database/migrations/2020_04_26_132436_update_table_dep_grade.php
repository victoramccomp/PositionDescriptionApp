<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDepGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dep_grade', function (Blueprint $table) {
            $table->string('status');
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
        Schema::table('dep_grade', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('requirement');
        });
    }
}
