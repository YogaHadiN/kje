<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsKontaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_kontaks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id_2');
            $table->integer('pcare_submit')->default(0);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('pesan')->nullable();
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['pasien_id'], 'pasien_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_kontaks');
    }
}
