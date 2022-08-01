<?php

namespace Database\Seeders;

use App\Models\Rating_poubelle;
use App\Models\Stock_poubelle;
use Illuminate\Database\Seeder;

class StockPoubelleSeeder extends Seeder{
    public function run(){
            Stock_poubelle::create([
                'type_poubelle'=>'plastique',
                'quantite_disponible'=>random_int(0,100),
                'pourcentage_remise'=>random_int(0,5)*10,
                'prix_unitaire'=>random_int(10,50)*10,
                'photo'=>'bleu.png',
            ]);

            Stock_poubelle::create([
                'type_poubelle'=>'papier',
                'quantite_disponible'=>random_int(0,100),
                'pourcentage_remise'=>random_int(0,5)*10,
                'prix_unitaire'=>random_int(10,50)*10,
                'photo'=>"jaune.png",
            ]);

            Stock_poubelle::create([
                'type_poubelle'=>'canette',
                'quantite_disponible'=>random_int(0,100),
                'pourcentage_remise'=>random_int(0,5)*10,
                'prix_unitaire'=>random_int(10,50)*10,
                'photo'=>"vert.png",
            ]);

            Stock_poubelle::create([
                'type_poubelle'=>'composte',
                'quantite_disponible'=>random_int(0,100),
                'pourcentage_remise'=>random_int(0,5)*10,
                'prix_unitaire'=>random_int(10,50)*10,
                'photo'=>"rouge.png",
            ])->each(function ($u) {
                $u->rating_poubelle()->save(Rating_poubelle::create([
                    'responsable_etablissement_id'=>\App\Models\Responsable_etablissement::all()->random()->id,
                    'stock_poubelle_id'=>1,
                    'rating'=>random_int(0,5),
                ]));
            });
        }
}
