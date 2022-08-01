<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReschoolInforamtionsTable extends Migration{
    public function up(){
        Schema::create('reschool_inforamtions', function (Blueprint $table) {
            $table->id();
            $table->string('adresse');
            $table->string('email1');
            $table->string('number_telephone1');
            $table->string('number_telephone2');
            $table->string('url_facebook');
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('reschool_inforamtions');
    }
}
