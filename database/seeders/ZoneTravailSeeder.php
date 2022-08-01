<?php

namespace Database\Seeders;

use App\Models\Camion;
use App\Models\Zone_depot;
use App\Models\Zone_travail;
use Illuminate\Database\Seeder;

class ZoneTravailSeeder extends Seeder{
    public function run(){
        $region=['Tunis','Ariana','Ben Arous','Mannouba','Nabeul','Zaghouan','Bizerte','Beja','Jendouba','Le Kef','Siliana','Kairouan','Kasserine','Sidi Bouzid','Sousse','Monastir','Mahdia','Sfax','Gafsa','Tozeur','Kebili','Gabes','Medenine','Tataouine'];
        foreach($region as $reg){
            Zone_travail::create([
                'region'=> $reg,
                'quantite_total_collecte_plastique'=> 0,
                'quantite_total_collecte_composte'=>0,
                'quantite_total_collecte_papier'=> 0,
                'quantite_total_collecte_canette'=>0,
            ]);
        }
        Zone_depot::factory(7)->create();

        Camion::factory(10)->create();

    }
}
