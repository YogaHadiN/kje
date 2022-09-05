<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentitems', function (Blueprint $table) {
            $table->timestamp('UpdatedInDB')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('InsertIntoDB')->default('0000-00-00 00:00:00');
            $table->timestamp('SendingDateTime')->default('0000-00-00 00:00:00');
            $table->timestamp('DeliveryDateTime')->nullable()->index('sentitems_date');
            $table->text('Text');
            $table->string('DestinationNumber', 20)->default('')->index('sentitems_dest');
            $table->enum('Coding', ['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression'])->default('Default_No_Compression');
            $table->text('UDH');
            $table->string('SMSCNumber', 20)->default('');
            $table->integer('Class')->default(-1);
            $table->text('TextDecoded');
            $table->unsignedInteger('ID')->default(0);
            $table->bigInteger('SenderID')->nullable()->index('SenderID');
            $table->integer('SequencePosition')->default(1);
            $table->enum('Status', ['SendingOK', 'SendingOKNoReport', 'SendingError', 'DeliveryOK', 'DeliveryFailed', 'DeliveryPending', 'DeliveryUnknown', 'Error'])->default('SendingOK');
            $table->integer('StatusError')->default(-1);
            $table->integer('TPMR')->default(-1)->index('sentitems_tpmr');
            $table->integer('RelativeValidity')->default(-1);
            $table->text('CreatorID');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->primary(['ID', 'SequencePosition']);
            $table->index(['SenderID'], 'sentitems_sender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sentitems');
    }
}
