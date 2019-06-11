<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRezervariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezervari', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cursa_id')->nullable();
            $table->unsignedBigInteger('statie_id')->nullable();
            $table->date('data_cursa')->nullable();
            $table->unsignedBigInteger('ora_id')->nullable();
            $table->string('zbor_oras_decolare')->nullable();
            $table->string('zbor_ora_decolare')->nullable();
            $table->string('zbor_ora_aterizare')->nullable();
            $table->string('nume');
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('nr_adulti')->nullable();
            $table->unsignedTinyInteger('nr_copii')->nullable();
            $table->decimal('pret_total')->nullable();
            $table->text('observatii')->nullable();
            $table->decimal('comision_agentie')->nullable();
            $table->decimal('plata_avans')->nullable();
            $table->unsignedBigInteger('tip_plata_id')->nullable();
            $table->boolean('activa')->default('1');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();

            $table->foreign('cursa_id')->references('id')->on('curse')->onDelete('cascade');
            $table->foreign( 'statie_id')->references('id')->on('orase_statii')->onDelete('cascade');
            $table->foreign('ora_id')->references('id')->on('curse_ore')->onDelete('cascade');
            $table->foreign( 'tip_plata_id')->references('id')->on('tip_plata')->onDelete('cascade');
            $table->foreign( 'user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rezervari');
    }
}
