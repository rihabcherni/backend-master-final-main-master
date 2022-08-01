<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingDechetsTable extends Migration{
    public function up()
    {
        Schema::create('rating_dechets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_dechet_id')->constrained('client_dechets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('dechet_id')->constrained('dechets')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('rating');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::table("rating_dechets",function(Blueprint $table){
            $table->dropForeignKey("client_dechet_id");
        });
        Schema::table("rating_dechets",function(Blueprint $table){
            $table->dropForeignKey("dechet_id");
        });
        Schema::dropIfExists('rating_dechets');
    }
}
