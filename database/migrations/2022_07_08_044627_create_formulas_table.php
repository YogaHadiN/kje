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
            $table->id();
            $table->string('indikasi')->nullable();
            $table->string('kontraindikasi')->nullable();
            $table->string('efek_samping')->nullable();
            $table->string('dijual_bebas')->nullable();
            $table->string('sediaan')->nullable();
            $table->integer('aturan_minum_id')->nullable();
            $table->string('peringatan')->nullable();
            $table->tinyInteger('boleh_dipuyer')->nullable();
            $table->bigInt('tenant_id')->index();
            $table->string('old_id')->nullable();
            $table->timestamps();
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
