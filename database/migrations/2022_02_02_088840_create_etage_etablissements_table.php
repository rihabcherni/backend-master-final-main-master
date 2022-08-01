<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtageEtablissementsTable extends Migration{
    public function up(){
        Schema::create('etage_etablissements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bloc_etablissement_id')->constrained('bloc_etablissements')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nom_etage_etablissement');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down() {
        Schema::table("etage_etablissements",function(Blueprint $table){
            $table->dropForeignKey("bloc_etablissement_id");
        });
        Schema::dropIfExists('etage_etablissements');
    }
};
