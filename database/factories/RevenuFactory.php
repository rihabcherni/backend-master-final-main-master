<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RevenuFactory extends Factory{
    public function definition()
    {
        return [
            'etablissement_id'=>'plastique',
            'mois'=>'plastique',
            'quantite_plastique_menusel'=>$this->faker->randomFloat(3,0, 5000),
            'quantite_papier_menusel'=>$this->faker->randomFloat(3,0, 5000),
            'quantite_composte_menusel'=>$this->faker->randomFloat(3,0, 5000),
            'quantite_canette_menusel'=>$this->faker->randomFloat(3,0, 5000),
            'revenu_total'=>$this->faker->randomFloat(3,0, 50000),
            'revenu_gestionnaire'=>$this->faker->randomFloat(3,0, 50000),
            'revenu_responsable'=>$this->faker->randomFloat(3,0, 50000),
        ];
    }
}
