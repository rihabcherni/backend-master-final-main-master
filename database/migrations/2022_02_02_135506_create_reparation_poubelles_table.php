<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReparationPoubellesTable extends Migration{
    public function up()
    {
        Schema::create('reparation_poubelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poubelle_id')->constrained('poubelles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('reparateur_poubelle_id')->constrained('reparateur_poubelles')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image_panne_poubelle');
            $table->text('description_panne');
            $table->float('cout');
            $table->dateTime('date_debut_reparation');
            $table->dateTime('date_fin_reparation');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down() {
        Schema::table("reparation_poubelles",function(Blueprint $table){
            $table->dropForeignKey("poubelle_id");
        });
        Schema::table("reparation_poubelles",function(Blueprint $table){
            $table->dropForeignKey("reparateur_poubelle_id");
        });
        Schema::dropIfExists('reparation_poubelles');
    }
}
