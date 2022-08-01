<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class Reparation_camionFactory extends Factory{
    public function definition(){
        return [
            'camion_id'=>\App\Models\Camion::all()->random()->id,
            'mecanicien_id'=>\App\Models\Mecanicien::all()->random()->id,
            'image_panne_camion' => "panne-camion.jfif",
            'description_panne'=> $this->faker->sentence,
            'cout'=> $this->faker->numberBetween(10,900)*10,
            'date_debut_reparation'=>$this->faker->dateTimeInInterval('-1 week', '1 days')->format('Y.m.d H:i:s'),
            'date_fin_reparation'=>$this->faker->dateTimeThisMonth('+7 days')->format('Y.m.d H:i:s'),

        ];
    }
}
