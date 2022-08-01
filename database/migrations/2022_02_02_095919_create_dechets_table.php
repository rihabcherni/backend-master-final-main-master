<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateDechetsTable extends Migration{
    public function up(){
        Schema::create('dechets', function (Blueprint $table) {
            $table->id();
            $table->enum('type_dechet',['plastique', 'composte','papier','canette']);
            $table->float('prix_unitaire');
            $table->string('photo')->nullable();
            $table->float("pourcentage_remise")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(){
        Schema::dropIfExists('dechets');
    }
}
