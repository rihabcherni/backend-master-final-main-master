<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateStockPoubellesTable extends Migration{
    public function up(){
        Schema::create('stock_poubelles', function (Blueprint $table) {
            $table->id();
            $table->enum('type_poubelle',['plastique', 'composte','papier','canette']);
            $table->integer('quantite_disponible')->default(0);
            $table->string('description');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(){
        Schema::dropIfExists('stock_poubelles');
    }
};
