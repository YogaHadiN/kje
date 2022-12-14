<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpDateValidationAvailableColumnToTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->tinyInteger('exp_date_validation_available')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('exp_date_validation_available');
        });
    }
}
