<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPreviousComplaintResolvedAlergiObatAndMemilihObatPatenNullableToAntrianApoteksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrian_apoteks', function (Blueprint $table) {
            $table->integer('previous_complaint_resolved')->nullable()->change();
            $table->integer('memilih_obat_paten')->nullable()->change();
            $table->integer('alergi_obat')->nullable()->change();
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
            $table->integer('previous_complaint_resolved')->default(1)->change();
            $table->integer('memilih_obat_paten')->default(1)->change();
            $table->integer('alergi_obat')->default(0)->change();
        });
    }
}
