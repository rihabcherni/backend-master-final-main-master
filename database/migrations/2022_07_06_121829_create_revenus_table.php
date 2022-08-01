<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenusTable extends Migration{
    public function up(){
        Schema::create('revenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained('etablissements')->onDelete('cascade')->onUpdate('cascade');
            $table->date('mois');
            $table->float('quantite_plastique_menusel');
            $table->float('quantite_papier_menusel');
            $table->float('quantite_composte_menusel');
            $table->float('quantite_canette_menusel');
            $table->float('revenu_total');
            $table->float('revenu_gestionnaire');
            $table->float('revenu_responsable');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::table("revenus",function(Blueprint $table){
            $table->dropForeignKey("etablissement_id");
        });
        Schema::dropIfExists('revenus');
    }
}
