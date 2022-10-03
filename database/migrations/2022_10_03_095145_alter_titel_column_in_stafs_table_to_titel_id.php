<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTitelColumnInStafsTableToTitelId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stafs', function (Blueprint $table) {
              $table->renameColumn('titel', 'titel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stafs', function (Blueprint $table) {
              $table->renameColumn( 'titel_id','titel');
        });
    }
}
