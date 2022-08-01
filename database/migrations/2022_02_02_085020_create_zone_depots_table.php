<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateZoneDepotsTable extends Migration{
    public function up(){
        Schema::create('zone_depots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_travail_id')->constrained('zone_travails')->onDelete('cascade')->onUpdate('cascade');
            $table->string('adresse')->unique();
            $table->float('longitude',30,27);
            $table->float('latitude',30,27);
            $table->float('quantite_depot_maximale');
            $table->float('quantite_depot_actuelle_plastique')->default(0);
            $table->float('quantite_depot_actuelle_papier')->default(0);
            $table->float('quantite_depot_actuelle_composte')->default(0);
            $table->float('quantite_depot_actuelle_canette')->default(0);
            $table->unique( array('longitude','latitude') );
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(){
        Schema::dropIfExists('zone_depots');
        Schema::table("zone_depots",function(Blueprint $table){
            $table->dropForeignKey("zone_travail_id");
        });
    }
}
