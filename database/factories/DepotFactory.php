<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class DepotFactory extends Factory{
    public function definition(){
        return [
            'zone_depot_id'=>\App\Models\Zone_depot::all()->random()->id,
            'camion_id'=>\App\Models\Camion::all()->random()->id,
            'date_depot'=>$this->faker->dateTimeInInterval('-1 year', '1 year')->format('Y.m.d H:i:s'),
            'quantite_depose_plastique'=> $this->faker->numberBetween(10,900)*10,
            'quantite_depose_papier'=> $this->faker->numberBetween(10,900)*10,
            'quantite_depose_composte'=> $this->faker->numberBetween(10,900)*10,
            'quantite_depose_canette'=>$this->faker->numberBetween(10,900)*10,
        ];
    }
}
