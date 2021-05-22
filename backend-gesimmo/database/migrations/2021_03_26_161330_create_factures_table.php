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
            $table->date('mois_paiement')->nullable();
            $table->string('type')->nullable();
            $table->double('montant_total')->nullable();
            $table->string('etat_paiement')->nullable();
            $table->double('montant_recu')->nullable();
            $table->date('date_paiement')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->integer('mois_impaye')->nullable();
            $table->boolean('archive')->nullable();
            $table->integer('nbt_relance')->nullable();
            $table->integer('nbr_relance_total')->nullable();
            $table->string('description')->nullable();
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
