<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgetPasswordsTable extends Migration{
    public function up(){
        Schema::create('forget_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('user_type');
            $table->string('code');
            $table->dateTime('date_expiration_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(){
        Schema::dropIfExists('forget_passwords');
    }
}
