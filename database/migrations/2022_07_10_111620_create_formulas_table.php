<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulas', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('indikasi');
            $table->string('kontraindikasi');
            $table->string('efek_samping');
            $table->string('dijual_bebas');
            $table->string('sediaan_id');
            $table->integer('aturan_minum_id');
            $table->mediumText('peringatan')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('boleh_dipuyer')->nullable();
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
        Schema::dropIfExists('formulas');
    }
}
