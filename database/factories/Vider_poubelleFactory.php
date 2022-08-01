<?php
namespace Database\Factories;

use App\Models\Poubelle;
use Illuminate\Database\Eloquent\Factories\Factory;
class Vider_poubelleFactory extends Factory{
    public function definition() {
        $poubelle_id=\App\Models\Poubelle::where("Etat", '>' ,75.0)->get()->random()->id;
        $poubelle= Poubelle::where('id', $poubelle_id)->first();
        $etat= $poubelle->Etat;
        $type= $poubelle->type;
        $quantite_plastique =0;
        $quantite_papier =0;
        $quantite_composte =0;
        $quantite_canette =0;
        if($type==="plastique"){
          $quantite_plastique= $etat*config('global.capacite_poubelle')/100;
        }else if($type==="papier"){
          $quantite_papier= $etat*config('global.capacite_poubelle')/100;
        }else if($type==="composte"){
          $quantite_composte= $etat*config('global.capacite_poubelle')/100;
        }else if($type==="canette"){
          $quantite_canette= $etat*config('global.capacite_poubelle')/100;
        }
        return[
            'poubelle_id'=>$poubelle_id,
            'camion_id'=>\App\Models\Camion::all()->random()->id,
            'date_depot'=>$this->faker->dateTimeInInterval('-1 year','1 year')->format('Y.m.d H:i:s'),
            'quantite_depose_plastique'=>$quantite_plastique,
            'etat'=>$etat,
            'quantite_depose_papier'=>$quantite_papier,
            'quantite_depose_composte'=>$quantite_composte,
            'quantite_depose_canette'=>$quantite_canette,
            'type_poubelle'=>$type,
        ];
    }
}
