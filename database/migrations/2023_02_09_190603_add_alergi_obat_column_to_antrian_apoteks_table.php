<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlergiObatColumnToAntrianApoteksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrian_apoteks', function (Blueprint $table) {
            $table->tinyInteger('alergi_obat')->default(0);
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
            $table->dropColumn('alergi_obat');
        });
    }
}
