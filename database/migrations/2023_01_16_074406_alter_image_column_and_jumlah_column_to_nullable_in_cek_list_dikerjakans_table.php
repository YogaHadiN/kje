<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterImageColumnAndJumlahColumnToNullableInCekListDikerjakansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cek_list_dikerjakans', function (Blueprint $table) {
            $table->integer('jumlah')->nullable()->change();
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cek_list_dikerjakans', function (Blueprint $table) {
            $table->integer('jumlah')->change();
            $table->string('image')->change();
        });
    }
}
