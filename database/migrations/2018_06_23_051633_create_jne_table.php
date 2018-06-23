<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jne', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->text('no_resi');
            $table->text('yes');
            $table->text('reg');
            $table->text('oke');
            $table->text('ass');
            $table->text('tujuan');
            $table->text('pengirim');
            $table->text('penerima');
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
        Schema::dropIfExists('jne');
    }
}
