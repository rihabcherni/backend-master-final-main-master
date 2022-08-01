<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateBlocPoubellesTable extends Migration{
    public function up(){
        Schema::create('bloc_poubelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etage_etablissement_id')->constrained('etage_etablissements')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down(){
        Schema::table("bloc_poubelles",function(Blueprint $table){
            $table->dropForeignKey("etage_etablissement_id");
        });
        Schema::dropIfExists('bloc_poubelles');
    }
}
