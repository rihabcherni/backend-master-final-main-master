<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsableCommercialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_commercials', function (Blueprint $table) {
            $table->id();
            $table->string('nom',20);
            $table->string('prenom',20);
            $table->string('CIN')->unique();
            $table->string('numero_telephone')->unique();;
            $table->string('email',40)->unique();
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mot_de_passe',255);
            $table->string('QRcode',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsable_commercials');
    }
}
