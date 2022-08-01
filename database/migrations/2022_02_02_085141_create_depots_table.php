<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDepotsTable extends Migration{
    public function up()
    {
        Schema::create('depots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_depot_id')->constrained('zone_depots')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('camion_id')->constrained('camions')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('date_depot');
            $table->float('quantite_depose_plastique');
            $table->float('quantite_depose_papier');
            $table->float('quantite_depose_composte');
            $table->float('quantite_depose_canette');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down()
    {
        Schema::table("depots",function(Blueprint $table){
            $table->dropForeignKey("zone_depot_id");
        });

        Schema::table("depots",function(Blueprint $table){
            $table->dropForeignKey("camion_id");
        });
        Schema::dropIfExists('depots');
    }
}
