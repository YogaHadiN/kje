<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbox', function (Blueprint $table) {
            $table->timestamp('UpdatedInDB')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('InsertIntoDB')->default('0000-00-00 00:00:00');
            $table->timestamp('SendingDateTime')->default('0000-00-00 00:00:00');
            $table->time('SendBefore')->default('23:59:59');
            $table->time('SendAfter')->default('00:00:00');
            $table->text('Text')->nullable();
            $table->string('DestinationNumber', 20)->default('');
            $table->enum('Coding', ['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression'])->default('Default_No_Compression');
            $table->text('UDH')->nullable();
            $table->integer('Class')->nullable()->default(-1);
            $table->text('TextDecoded');
            $table->increments('ID');
            $table->enum('MultiPart', ['false', 'true'])->nullable()->default('false');
            $table->integer('RelativeValidity')->nullable()->default(-1);
            $table->bigInteger('SenderID')->nullable()->index();
            $table->timestamp('SendingTimeOut')->nullable()->default('0000-00-00 00:00:00');
            $table->enum('DeliveryReport', ['default', 'yes', 'no'])->nullable()->default('default');
            $table->text('CreatorID');
            $table->integer('Retries')->nullable()->default(0);
            $table->integer('Priority')->nullable()->default(0);
            $table->bigInteger('tenant_id')->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outbox');
    }
}
