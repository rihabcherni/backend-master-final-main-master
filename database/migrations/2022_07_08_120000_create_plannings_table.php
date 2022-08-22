<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained('etablissements')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jour');
            $table->string('start');
            $table->string('end');
            $table->boolean('validation')->default(0);
            $table->enum('statut', ['confirmed', 'non confirmed','collected','problem'])->default('non confirmed');
            $table->dateTime('date_collecte')->nullable();
            $table->string('type_poubelle');
            $table->integer('id_ouvrier')->nullable();
            // $table->foreignId('id_ouvrier')->constrained('ouvriers')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table("plannings",function(Blueprint $table){
            $table->dropForeignKey("etablissement_id");
        });

        Schema::dropIfExists('plannings');
    }
}
