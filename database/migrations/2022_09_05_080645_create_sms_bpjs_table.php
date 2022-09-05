<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsBpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_bpjs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id');
            $table->string('pesan');
            $table->string('callBackUrl');
            $table->integer('pcare_submit')->default(0);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('old_id')->index('old_id');

            $table->index(['pasien_id'], 'pasien_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_bpjs');
    }
}
