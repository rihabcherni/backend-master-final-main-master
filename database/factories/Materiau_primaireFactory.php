<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class Materiau_primaireFactory extends Factory{
    public function definition(){
        return [
            'fournisseur_id'=>\App\Models\Fournisseur::all()->random()->id,
            'nom_materiel'=>$this->faker->word,
            'prix_unitaire'=>$this->faker->randomFloat(3,1000,9999),
            'quantite'=>$this->faker->numberBetween(1,100),
            'prix_total'=>$this->faker->randomFloat(3,1000,9999),
        ];
    }
}
