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
            $table->date('date_paiement')->nullable();
            $table->string('etat_paiement')->nullable();
            $table->string('type')->nullable();
            $table->string('statut')->nullable();
            $table->double('loyer_mensuel')->nullable();
            $table->double('syndic')->nullable();
            $table->double('taxe')->nullable();
            $table->string('description')->nullable();
            $table->double('montant')->nullable();
            $table->integer('nbt_relance')->nullable();
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
