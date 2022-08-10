<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtablissementsTable extends Migration{
    public function up(){
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_travail_id')->constrained('zone_travails')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('camion_id')->constrained('camions')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->string('nom_etablissement',30)->unique();
            $table->enum('type_etablissement', ['privee','public']);
            $table->enum('niveau_etablissement', ['ecole primaire', 'college','ecole secondaire','universite','societe']);
            $table->integer('nbr_personnes');
            $table->string('url_map');
            $table->string('adresse')->unique();
            $table->float('longitude',30,27);
            $table->float('latitude',30,27);
            $table->float('quantite_dechets_plastique')->default(0);
            $table->float('quantite_dechets_composte')->default(0);
            $table->float('quantite_dechets_papier')->default(0);
            $table->float('quantite_dechets_canette')->default(0);

            $table->float('quantite_plastique_mensuel')->default(0);
            $table->float('quantite_papier_mensuel')->default(0);
            $table->float('quantite_composte_mensuel')->default(0);
            $table->float('quantite_canette_mensuel')->default(0);

            $table->unique( array('longitude','latitude') );
            $table->timestamps();
            $table->softDeletes();

        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {


        Schema::table("etablissements",function(Blueprint $table){
            $table->dropForeignKey("camion_id");
        });

        Schema::table("etablissements",function(Blueprint $table){
            $table->dropForeignKey("zone_travail_id");
        });

        Schema::dropIfExists('etablissements');
    }
}
