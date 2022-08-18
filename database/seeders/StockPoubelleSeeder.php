<?php

namespace Database\Seeders;

use App\Models\Rating_poubelle;
use App\Models\Stock_poubelle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StockPoubelleSeeder extends Seeder{
    public function run(){
        $desc1="";
        $desc2="";
        $desc3="";
        $desc4="";
        $array = [7, 8, 3, 4, 5, 7 , 5 , 3];
        foreach($array as $a){
            $desc1= $desc1.Str::random($a)." ";
            $desc2= $desc2.Str::random($a)." ";
            $desc3= $desc3.Str::random($a)." ";
            $desc4= $desc4.Str::random($a)." ";
        }
        Stock_poubelle::create([
            'type_poubelle'=>'plastique',
            'quantite_disponible'=>random_int(0,100),
            'description'=>$desc2,
            'photo'=>'bleu.png',
        ]);

        Stock_poubelle::create([
            'type_poubelle'=>'papier',
            'quantite_disponible'=>random_int(0,100),
            'description'=>$desc1,
            'photo'=>"jaune.png",
        ]);

        Stock_poubelle::create([
            'type_poubelle'=>'canette',
            'quantite_disponible'=>random_int(0,100),
            'description'=>$desc3,
            'photo'=>"vert.png",
        ]);

        Stock_poubelle::create([
            'type_poubelle'=>'composte',
            'quantite_disponible'=>random_int(0,100),
            'description'=>$desc4,
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
