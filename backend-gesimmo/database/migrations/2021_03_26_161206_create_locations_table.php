<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('identifiant')->nullable();
            $table->date('date_entree')->nullable();
            $table->date('date_sortie')->nullable();
            $table->double('montant')->nullable();
            $table->double('duree')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('bien_id')->constrained()->onUpdate('cascade');
            $table->string('archive')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
