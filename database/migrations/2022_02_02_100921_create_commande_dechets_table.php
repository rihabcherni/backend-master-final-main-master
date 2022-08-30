<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeDechetsTable extends Migration{
    public function up()
    {
        Schema::create('commande_dechets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_dechet_id')->constrained('client_dechets')->onDelete('cascade')->onUpdate('cascade');
            $table->float('quantite_plastique')->nullable();
            $table->float('quantite_papier')->nullable();
            $table->float('quantite_composte')->nullable();
            $table->float('quantite_canette')->nullable();
            $table->float('prix_plastique')->nullable();
            $table->float('prix_papier')->nullable();
            $table->float('prix_composte')->nullable();
            $table->float('prix_canette')->nullable();
            $table->enum('type_paiment',['en ligne','en cheque','en espece'])->nullable();
            $table->float('montant_total')->nullable();
            $table->datetime('date_commande')->nullable();
            $table->datetime('date_livraison')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }
    public function down()
    {
        Schema::table("commande_dechets",function(Blueprint $table){
            $table->dropForeignKey("client_dechet_id");
        });
        Schema::dropIfExists('commande_dechets');
    }
}
