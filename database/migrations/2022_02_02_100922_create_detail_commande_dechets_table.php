<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDetailCommandeDechetsTable extends Migration{
    public function up() {
        Schema::create('detail_commande_dechets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_dechet_id')->constrained('commande_dechets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('dechet_id')->constrained('dechets')->onDelete('cascade')->onUpdate('cascade');
            $table->float('quantite');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down() {
        Schema::table("detail_commande_dechets",function(Blueprint $table){
            $table->dropForeignKey("commande_dechet_id");
        });
        Schema::table("detail_commande_dechets",function(Blueprint $table){
            $table->dropForeignKey("dechet_id");
        });
        Schema::dropIfExists('detail_commande_dechets');
    }
};
