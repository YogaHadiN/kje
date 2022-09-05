<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispensingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispensings', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->date('tanggal');
            $table->integer('keluar')->default(0);
            $table->integer('masuk')->default(0);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('dispensable_id')->nullable()->index('dispensable_id_2');
            $table->string('dispensable_type');
            $table->bigInteger('merek_id')->nullable()->index('merek_id');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('old_id')->index('old_id');

            $table->index(['dispensable_id', 'dispensable_type'], 'dispensable_id');
            $table->index(['merek_id'], 'merek_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispensings');
    }
}
