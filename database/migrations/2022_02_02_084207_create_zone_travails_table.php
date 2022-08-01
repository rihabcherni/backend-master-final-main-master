<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneTravailsTable extends Migration
{
    public function up()
    {
        Schema::create('zone_travails', function (Blueprint $table) {
            $table->id();
            $table->string('region')->unique();;
            $table->float('quantite_total_collecte_plastique')->default(0);
            $table->float('quantite_total_collecte_composte')->default(0);
            $table->float('quantite_total_collecte_papier')->default(0);
            $table->float('quantite_total_collecte_canette')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('zone_travails');
    }
}
