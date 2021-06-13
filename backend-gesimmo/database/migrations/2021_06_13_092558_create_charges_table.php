<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->double('montant_total')->nullable();
            $table->string('etat_paiement')->nullable();
            $table->double('montant_recu')->nullable();
            $table->date('date_paiement')->nullable();
            //$table->string('mode_paiement')->nullable();
            $table->boolean('archive')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('bien_id')->constrained('biens')->onUpdate('cascade');
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
        Schema::dropIfExists('charges');
    }
}
