<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDepAddcolumnHomeoffice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('position_description', function (Blueprint $table) {
            $table->integer('allowhomeoffice')->default(false);
            $table->integer('company_id')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('position_description', function (Blueprint $table) {
            $table->dropColumn('allowhomeoffice');
            $table->dropColumn('company_id');
        });
    }
}
