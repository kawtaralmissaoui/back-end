<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modes', function (Blueprint $table) {
            $table->id();
            $table->double('montant')->nullable();
            $table->string('mode_paiement')->nullable();            
            $table->string('numero_operation')->nullable();
            $table->string('banque')->nullable();
            $table->string('numero_remise')->nullable();
            $table->date('date')->nullable();
            $table->integer('execution')->nullable();
            $table->string('etat')->nullable();
            $table->string('description')->nullable();;
            $table->foreignId('facture_id')->constrained('factures')->onUpdate('cascade');
            $table->date('date_remise')->nullable();
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
        Schema::dropIfExists('modes');
    }
}
