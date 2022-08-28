<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReponsableTechniquesTable extends Migration{
    public function up(){
        Schema::create('responsable_techniques', function (Blueprint $table) {
            $table->id();
            $table->string('nom',30);
            $table->string('prenom',30);
            $table->string('CIN',8)->unique();
            $table->string('photo')->nullable();
            $table->string('numero_telephone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mot_de_passe');
            $table->string('adresse')->unique();
            $table->string('QRcode',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('responsable_techniques');
    }
}
