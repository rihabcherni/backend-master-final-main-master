<?php

namespace Database\Seeders;

use App\Models\Dechet;
use Illuminate\Database\Seeder;

class DechetSeeder extends Seeder{
    public function run(){
        Dechet::create([
            'type_dechet'=> 'plastique',
            'prix_unitaire'=>1.2,
            'pourcentage_remise'=>random_int(0,5)*10,
            'photo' =>"plastique.png",
        ]);
        Dechet::create([
            'type_dechet'=> 'composte',
            'prix_unitaire'=>1.5,
            'pourcentage_remise'=>random_int(0,5)*10,
            'photo' =>"composte.png",
        ]);
        Dechet::create([
            'type_dechet'=> 'papier',
            'pourcentage_remise'=>random_int(0,5)*10,
            'prix_unitaire'=>0.8,
            'photo' =>"papier.png",
        ]);
        Dechet::create([
            'type_dechet'=> 'canette',
            'pourcentage_remise'=>random_int(0,5)*10,
            'prix_unitaire'=>1.4,
            'photo' =>"canette.png",
        ]);
    }
}
