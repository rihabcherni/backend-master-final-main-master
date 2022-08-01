<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingPoubellesTable extends Migration{
    public function up()
    {
        Schema::create('rating_poubelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsable_etablissement_id')->constrained('responsable_etablissements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('stock_poubelle_id')->constrained('stock_poubelles')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('rating');
            $table->timestamps();
            $table->softDeletes();

        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::table("rating_poubelles",function(Blueprint $table){
            $table->dropForeignKey("responsable_etablissement_id");
        });
        Schema::table("rating_poubelles",function(Blueprint $table){
            $table->dropForeignKey("stock_poubelle_id");
        });
        Schema::dropIfExists('rating_poubelles');
    }
}
