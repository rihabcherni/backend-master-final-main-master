<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMateriauPrimairesTable extends Migration{
    public function up(){
        Schema::create('materiau_primaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fournisseur_id')->constrained('fournisseurs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nom_materiel');
            $table->float('prix_unitaire');
            $table->integer('quantite')->default(0);
            $table->float('prix_total');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down(){
        Schema::table("materiau_primaires",function(Blueprint $table){
            $table->dropForeignKey("fournisseur_id");
        });
        Schema::dropIfExists('materiau_primaires');
    }
};
