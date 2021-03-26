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
            $table->date('date_entree');
            $table->date('date_sortie');
            $table->double('montant');
            $table->string('type');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('bien_id')->constrained()->onUpdate('cascade');
            $table->string('archive');
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
