<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviousComplaintResolvedToAntrianPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrian_periksas', function (Blueprint $table) {
            $table->string('previous_complaint_resolved')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antrian_periksas', function (Blueprint $table) {
            $table->dropColumn('previous_complaint_resolved');
        });
    }
}
