<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingServicesTable extends Migration{
    public function up(){
        Schema::create('rating_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsable_etablissement_id')->constrained('responsable_etablissements')->onDelete('cascade')->onUpdate('cascade');
            $table->string('services');
            $table->tinyInteger('rating');
            $table->timestamps();
            $table->softDeletes();
        });
         Schema::enableForeignKeyConstraints();
    }

    public function down(){
        Schema::table("rating_services",function(Blueprint $table){
            $table->dropForeignKey("responsable_etablissement_id");
        });
        Schema::dropIfExists('rating_services');
    }
}
