<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOraseStatiiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orase_statii', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('oras_id');
            $table->string('nume');
            $table->timestamps();

            $table->foreign('oras_id')->references('id')->on('orase')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orase_statii');
    }
}
