<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('identifiant')->unique();
            $table->string('adresse')->nullable();
            $table->double('surface')->nullable();
            $table->string('statut')->nullable();
            $table->string('type')->nullable();
            $table->string('code_postal')->nullable();
            $table->double('loyer_mensuel')->nullable();
            $table->double('syndic')->nullable();
            $table->double('taxe_habitation')->nullable();
            $table->string('archive')->nullable();
            $table->integer('nbr_piece')->nullable();
            $table->boolean('equipement')->nullable();
            $table->boolean('ascenseur')->nullable();
            $table->integer('etage')->nullable();
            $table->integer('porte')->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade');
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
        Schema::dropIfExists('biens');
    }
}
