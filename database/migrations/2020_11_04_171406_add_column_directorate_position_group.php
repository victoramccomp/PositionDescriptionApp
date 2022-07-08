<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDirectoratePositionGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('position', function (Blueprint $table) {
            $table->unsignedBigInteger('directorate_id')->nullable();
            $table->unsignedBigInteger('position_group_id')->nullable();

            $table->foreign('directorate_id')->references('id')->on('directorate');
            $table->foreign('position_group_id')->references('id')->on('position_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
