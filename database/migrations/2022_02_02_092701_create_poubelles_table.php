<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoubellesTable extends Migration
{
    public function up()
    {
        Schema::create('poubelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bloc_poubelle_id')->constrained('bloc_poubelles')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nom');
            $table->string('QRcode',255)->nullable();
            $table->enum('type', ['plastique', 'composte','papier','canette']);
            $table->float('Etat')->default(0);
            // $table->unique( array('type','bloc_poubelle_id') );
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
      }
    public function down()
    {
        Schema::table("poubelles",function(Blueprint $table){
            $table->dropForeignKey("bloc_poubelle_id");
        });
        Schema::dropIfExists('poubelles');
    }
}
