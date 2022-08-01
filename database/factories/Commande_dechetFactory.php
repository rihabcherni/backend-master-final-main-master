<?php
namespace Database\Factories;

use App\Models\Commande_dechet;
use Illuminate\Database\Eloquent\Factories\Factory;
class Commande_dechetFactory extends Factory
{
    protected $model = Commande_dechet::class;

    public function definition()
    {
        return [
            'client_dechet_id'=>\App\Models\Client_dechet::all()->random()->id,
            'type_paiment'=>  $this->faker->randomElement(['en ligne','en cheque','en espece']),
            'montant_total'=> $this->faker->numberBetween(100,10000),
            'date_commande'=>$this->faker->dateTimeBetween('now', '+1 days')->format('Y.m.d H:i:s'),
            'date_livraison'=>$this->faker->dateTimeBetween('+5 days', '+30 days')->format('Y.m.d H:i:s'),
        ];
    }
}

