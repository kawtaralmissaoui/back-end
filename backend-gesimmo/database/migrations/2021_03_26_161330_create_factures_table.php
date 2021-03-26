<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->date('date_paiement');
            $table->string('etat_paiement');
            $table->string('type');
            $table->string('statut');
            $table->double('loyer_mensuel');
            $table->double('syndic');
            $table->double('taxe');
            $table->double('reparation');
            $table->double('personnel');
            $table->integer('nbt_relance');
            $table->foreignId('location_id')->constrained('locations')->onUpdate('cascade');
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
        Schema::dropIfExists('factures');
    }
}
