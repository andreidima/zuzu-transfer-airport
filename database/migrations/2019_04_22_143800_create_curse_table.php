<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curse', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedBigInteger('traseu_id');
            $table->unsignedBigInteger('plecare_id');
            $table->unsignedBigInteger('sosire_id');
            $table->time('durata');
            $table->decimal('pret_adult');
            $table->decimal('pret_copil');
            $table->decimal('pret_adult_retur');
            $table->decimal('pret_copil_retur');
            $table->timestamps();

            // $table->foreign( 'traseu_id')->references('id')->on('trasee')->onDelete('cascade');
            $table->foreign( 'plecare_id')->references('id')->on('orase')->onDelete('cascade');
            $table->foreign( 'sosire_id')->references('id')->on('orase')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curse');
    }
}
