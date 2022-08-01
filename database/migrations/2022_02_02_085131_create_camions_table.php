<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateCamionsTable extends Migration{
    public function up(){
        Schema::create('camions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_travail_id')->constrained('zone_travails')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('zone_depot_id')->constrained('zone_depots')->onDelete('cascade')->onUpdate('cascade');
            $table->string('matricule');
            $table->string('QRcode',255)->nullable();
            $table->datetime('heure_sortie')->nullable();
            $table->datetime('heure_entree')->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->float('volume_maximale_camion')->nullable();
            $table->float('volume_actuelle_plastique')->nullable();
            $table->float('volume_actuelle_papier')->nullable();
            $table->float('volume_actuelle_composte')->nullable();
            $table->float('volume_actuelle_canette')->nullable();
            $table->float('volume_carburant_consomme')->default(0);
            $table->float('Kilometrage')->default(0);
            $table->unique( array('longitude','latitude'));
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down()
    {
        Schema::table("camions",function(Blueprint $table){
            $table->dropForeignKey("zone_travail_id");
        });
        Schema::table("camions",function(Blueprint $table){
            $table->dropForeignKey("zone_depot_id");
        });
        Schema::dropIfExists('camions');
    }
}
