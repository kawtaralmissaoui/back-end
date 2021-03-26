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
            $table->string('adresse');
            $table->double('surface');
            $table->string('statut');
            $table->double('loyer_mensuel');
            $table->double('syndic');
            $table->double('taxe_habitation');
            $table->string('archive');
            $table->integer('nbr_piece');
            $table->boolean('equipement');
            $table->boolean('ascenseur');
            $table->integer('etage');
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
