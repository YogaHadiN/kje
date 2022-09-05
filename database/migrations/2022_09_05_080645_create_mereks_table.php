<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMereksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mereks', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('merek');
            $table->bigInteger('rak_id')->nullable()->index('rak_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('discontinue')->nullable()->default(0);
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('old_id')->index('old_id');

            $table->index(['rak_id'], 'rak_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mereks');
    }
}
