<?php
namespace Database\Factories;

use App\Models\Zone_travail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CamionFactory extends Factory{
    public function definition(){
        $zone_travail_id = \App\Models\Zone_travail::all()->random()->id;
        $zone_depot_id = \App\Models\Zone_depot::all()->random()->id;
        $matricule =  $this->faker->unique()->bothify('### tunis ####');
        $qrcode = Hash::make($matricule);
        return [
            'zone_travail_id'=> $zone_travail_id,
            'zone_depot_id'=> $zone_depot_id,
            'matricule' =>$matricule,
            'qrcode' => $qrcode,
            'heure_sortie'=>$this->faker->dateTimeBetween('now', '+1 days')->format('Y.m.d H:i:s'),
            'heure_entree'=>$this->faker->dateTimeBetween('now', '+2 days')->format('Y.m.d H:i:s'),
            'longitude'=> $this->faker->longitude($min = 10.1, $max = 10.25),
            'latitude'=> $this->faker->latitude($min = 36.75, $max = 36.8),
            'volume_maximale_camion'=>2000,
            'volume_actuelle_plastique'=>$this->faker->randomFloat(3,0, 1999),
            'volume_actuelle_papier'=> $this->faker->randomFloat(3,0, 1999),
            'volume_actuelle_composte'=>$this->faker->randomFloat(3,0, 1999),
            'volume_actuelle_canette'=> $this->faker->randomFloat(3,0, 1999),
            'volume_carburant_consomme'=> $this->faker->randomFloat(3,0,100),
            'Kilometrage'=> $this->faker->randomFloat(3,0, 100),
        ];
    }
}
