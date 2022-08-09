<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDechetsTable extends Migration
{
    public function up()
    {
        Schema::create('client_dechets', function (Blueprint $table) {
            $table->id();
            $table->string('nom_entreprise');
            $table->string('matricule_fiscale')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse');
            $table->string('numero_telephone')->unique();
            $table->string('numero_fixe')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mot_de_passe');
            $table->string('QRcode',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();
        });
    }
    public function down()
    {
        Schema::dropIfExists('client_dechets');
    }
}
