<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutboxMultipartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbox_multipart', function (Blueprint $table) {
            $table->text('Text')->nullable();
            $table->enum('Coding', ['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression'])->default('Default_No_Compression');
            $table->text('UDH')->nullable();
            $table->integer('Class')->nullable()->default(-1);
            $table->text('TextDecoded')->nullable();
            $table->unsignedInteger('ID')->default(0);
            $table->integer('SequencePosition')->default(1);
            $table->bigInteger('tenant_id')->index();

            $table->primary(['ID', 'SequencePosition']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outbox_multipart');
    }
}
