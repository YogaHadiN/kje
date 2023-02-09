<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviousComplaintResolvedToAntrianApoteksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrian_apoteks', function (Blueprint $table) {
            $table->tinyInteger('previous_complaint_resolved')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antrian_apoteks', function (Blueprint $table) {
            $table->dropColumn('previous_complaint_resolved');
        });
    }
}
