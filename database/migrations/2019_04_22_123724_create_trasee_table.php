<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraseeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trasee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('traseu_nume_id');
            $table->string('numar');
            $table->timestamps();

            $table->foreign('traseu_nume_id')->references('id')->on('trasee_nume')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trasee');
    }
}
