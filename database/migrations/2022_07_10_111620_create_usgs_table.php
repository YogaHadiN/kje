<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usgs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('periksa_id');
            $table->string('perujuk_id')->nullable();
            $table->date('hpht')->nullable();
            $table->string('umur_kehamilan')->nullable();
            $table->string('gpa')->nullable();
            $table->string('bpd')->nullable();
            $table->string('ltp')->nullable();
            $table->string('djj')->nullable();
            $table->string('ac')->nullable();
            $table->string('efw')->nullable();
            $table->string('fl')->nullable();
            $table->string('sex')->nullable();
            $table->string('ica')->nullable();
            $table->string('plasenta')->nullable();
            $table->string('presentasi')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->string('saran')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('bpd_mm')->default(0);
            $table->integer('fl_mm')->default(0);
            $table->integer('ac_mm')->default(0);
            $table->string('hc')->nullable();
            $table->integer('hc_mm')->nullable()->default(0);
            $table->bigInteger('tenant_id')->index();
            $table->string('old_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usgs');
    }
}
