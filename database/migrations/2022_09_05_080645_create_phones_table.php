<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->text('ID');
            $table->timestamp('UpdatedInDB')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('InsertIntoDB')->default('0000-00-00 00:00:00');
            $table->timestamp('TimeOut')->default('0000-00-00 00:00:00');
            $table->enum('Send', ['yes', 'no'])->default('no');
            $table->enum('Receive', ['yes', 'no'])->default('no');
            $table->string('IMEI', 35)->primary();
            $table->string('IMSI', 35);
            $table->string('NetCode', 10)->nullable()->default('ERROR');
            $table->string('NetName', 35)->nullable()->default('ERROR');
            $table->text('Client');
            $table->integer('Battery')->default(-1);
            $table->integer('Signal')->default(-1);
            $table->integer('Sent')->default(0);
            $table->integer('Received')->default(0);
            $table->bigInteger('tenant_id')->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
