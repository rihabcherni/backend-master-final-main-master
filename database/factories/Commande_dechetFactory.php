<?php
namespace Database\Factories;

use App\Models\Commande_dechet;
use App\Models\Dechet;
use Illuminate\Database\Eloquent\Factories\Factory;
class Commande_dechetFactory extends Factory
{
    protected $model = Commande_dechet::class;

    public function definition()
    {
        $quantite_plastique=$this->faker->numberBetween(100,1000);
        $quantite_papier=$this->faker->numberBetween(100,1000);
        $quantite_composte=$this->faker->numberBetween(100,1000);
        $quantite_canette=$this->faker->numberBetween(100,1000);

        $prix_plastique=$this->faker->numberBetween(100,1000);
        $prix_papier=$this->faker->numberBetween(100,1000);
        $prix_composte=$this->faker->numberBetween(100,1000);
        $prix_canette=$this->faker->numberBetween(100,1000);
        return [
            'client_dechet_id'=>\App\Models\Client_dechet::all()->random()->id,
            'quantite_plastique'=> $quantite_plastique,
            'quantite_papier'=> $quantite_papier,
            'quantite_composte'=> $quantite_composte,
            'quantite_canette'=> $quantite_canette,

            'prix_plastique'=> $prix_plastique,
            'prix_papier'=> $prix_papier,
            'prix_composte'=> $prix_composte,
            'prix_canette'=> $prix_canette,

            'type_paiment'=>  $this->faker->randomElement(['en ligne','en cheque','en espece']),
            'montant_total'=> $this->faker->numberBetween(100,10000),
            'date_commande'=>$this->faker->dateTimeBetween('now', '+1 days')->format('Y.m.d H:i:s'),
            'date_livraison'=>$this->faker->dateTimeBetween('+5 days', '+30 days')->format('Y.m.d H:i:s'),
        ];
    }
}

