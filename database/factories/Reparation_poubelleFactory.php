<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
class Reparation_poubelleFactory extends Factory{
    public function definition()
    {
        return [
            'poubelle_id'=>\App\Models\Poubelle::all()->random()->id,
            'reparateur_poubelle_id'=>\App\Models\Reparateur_poubelle::all()->random()->id,
            'image_panne_poubelle' => "panne1.jfif",
            'description_panne'=> $this->faker->sentence,
            'cout'=> $this->faker->numberBetween(5,10)*10,
            'date_debut_reparation'=>$this->faker->dateTimeInInterval('-1 week', '1 days')->format('Y.m.d H:i:s'),
            'date_fin_reparation'=>$this->faker->dateTimeThisMonth('+7 days')->format('Y.m.d H:i:s'),
        ];
    }
}
