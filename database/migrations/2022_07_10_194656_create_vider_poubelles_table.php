<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViderPoubellesTable extends Migration{
    public function up(){
        Schema::create('vider_poubelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poubelle_id')->constrained('poubelles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('camion_id')->constrained('camions')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('date_depot');
            $table->float('etat');
            $table->float('quantite_depose_plastique');
            $table->float('quantite_depose_papier');
            $table->float('quantite_depose_composte');
            $table->float('quantite_depose_canette');
            $table->enum('type_poubelle', ['plastique', 'composte','papier','canette']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(){
        Schema::dropIfExists('vider_poubelles');
    }
}
