<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('civilite');
            $table->string('nom');
            $table->string('prenom');
            $table->string('role');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('adresse');
            $table->string('telephone');
            $table->string('CIN');
            $table->boolean('archive');
            $table->string('password');
            $table->string('nom_responsable');
            $table->string('prenom_responsable');
            $table->string('nom_societe');
            $table->string('patente');
            $table->string('statut_societe');
            $table->mediumText('image');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
