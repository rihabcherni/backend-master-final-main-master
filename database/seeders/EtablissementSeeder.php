<?php

namespace Database\Seeders;

use App\Models\Etage_etablissement;
use App\Models\Etablissement;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Poubelle;
use App\Models\Responsable_etablissement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EtablissementSeeder extends Seeder{
    public function run(){
        Etablissement::create([
            'zone_travail_id'=>1,
            'camion_id'=>1,
            'nom_etablissement'=> 'ESSECT',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 3500,
            'url_map'=> 'https://goo.gl/maps/bJuBsVTcdLjxmFMw5',
            'adresse'=> '4, Rue Abou Zakaria El Hafsi - 1089 Montfleury - Tunis - 1089 Tunis',
            'longitude'=> 10.174750000000000000000000000,
            'latitude'=> 36.787200000000000000000000000,

            'quantite_dechets_plastique'=>200,
            'quantite_dechets_composte'=> 500,
            'quantite_dechets_papier'=> 300,
            'quantite_dechets_canette'=> 400,

            'quantite_plastique_mensuel'=>52000,
            'quantite_composte_mensuel'=> 2500,
            'quantite_papier_mensuel'=> 2300,
            'quantite_canette_mensuel'=> 3400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'camion_id'=>1,
            'nom_etablissement'=> 'FSEG',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 4000,
            'url_map'=>'https://goo.gl/maps/CEjvUY8Mz283VKn78',
            'adresse'=> 'Tunis, B.P 248 2092، Tunis',
            'longitude'=> 10.150930000000000000000000000,
            'latitude'=> 36.831850000000000000000000000,

            'quantite_dechets_plastique'=>300,
            'quantite_dechets_composte'=> 700,
            'quantite_dechets_papier'=> 500,
            'quantite_dechets_canette'=> 800,

            'quantite_plastique_mensuel'=>6000,
            'quantite_composte_mensuel'=> 4500,
            'quantite_papier_mensuel'=> 6300,
            'quantite_canette_mensuel'=>7400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'camion_id'=>1,
            'nom_etablissement'=> 'ISG',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 3000,
            'url_map'=> 'https://goo.gl/maps/CTPFs8EkZpfYU5177',
            'adresse'=> '41 Av. de la Liberte, Tunis 2000',
            'longitude'=> 10.150433000000000000000000000,
            'latitude'=> 36.804441000000000000000000000,

            'quantite_dechets_plastique'=>600,
            'quantite_dechets_composte'=> 700,
            'quantite_dechets_papier'=> 900,
            'quantite_dechets_canette'=> 300,

            'quantite_plastique_mensuel'=>32000,
            'quantite_composte_mensuel'=> 5000,
            'quantite_papier_mensuel'=> 2800,
            'quantite_canette_mensuel'=> 6400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>2,
            'camion_id'=>2,
            'nom_etablissement'=> 'ISI',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 2000,
            'url_map'=> 'https://goo.gl/maps/YrXFuaSxCewfGv8x6',
            'adresse'=> 'Rue Abourraihan Al Bayrouni, Ariana 2080',
            'longitude'=> 10.188910000000000000000000000,
            'latitude'=> 36.861600000000000000000000000,

            'quantite_dechets_plastique'=>700,
            'quantite_dechets_composte'=> 800,
            'quantite_dechets_papier'=> 900,
            'quantite_dechets_canette'=> 800,

            'quantite_plastique_mensuel'=>32000,
            'quantite_composte_mensuel'=> 7500,
            'quantite_papier_mensuel'=> 9300,
            'quantite_canette_mensuel'=> 7400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'camion_id'=>1,
            'nom_etablissement'=> 'IHEC',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 3000,
            'url_map'=>'https://goo.gl/maps/dvJSDyY3vS61sSVx8',
            'adresse'=> 'Rue Victor Hugo, Site archéologique de Carthage',
            'longitude'=> 10.332830000000000000000000000,
            'latitude'=> 36.878860000000000000000000000,

            'quantite_dechets_plastique'=>20,
            'quantite_dechets_composte'=> 200,
            'quantite_dechets_papier'=> 10,
            'quantite_dechets_canette'=> 40,

            'quantite_plastique_mensuel'=>5000,
            'quantite_composte_mensuel'=> 2500,
            'quantite_papier_mensuel'=> 2300,
            'quantite_canette_mensuel'=> 3400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>4,
            'camion_id'=>4,
            'nom_etablissement'=> 'ESEN',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 2000,
            'url_map'=>'https://goo.gl/maps/zQPUUhbQkNKdzz9A9',
            'adresse'=> 'Technopole de la Manouba – Manouba CP 2010',
            'longitude'=> 10.073130000000000000000000000,
            'latitude'=> 36.807740000000000000000000000,
            'quantite_dechets_plastique'=>520,
            'quantite_dechets_composte'=> 2000,
            'quantite_dechets_papier'=> 300,
            'quantite_dechets_canette'=> 500,

            'quantite_plastique_mensuel'=>4700,
            'quantite_composte_mensuel'=> 1000,
            'quantite_papier_mensuel'=> 2300,
            'quantite_canette_mensuel'=> 3400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>4,
            'camion_id'=>4,
            'nom_etablissement'=> 'ISCAE',
            'niveau_etablissement'=> 'universite',
            'type_etablissement'=>'public',
            'nbr_personnes'=> 3200,
            'url_map'=>'https://goo.gl/maps/8dgifEeMXvGE72bs6',
            'adresse'=> 'Campus universitaire Manouba, 2010',
            'longitude'=> 10.060890000000000000000000000,
            'latitude'=> 36.815180000000000000000000000,
            'quantite_dechets_plastique'=>20,
            'quantite_dechets_composte'=> 200,
            'quantite_dechets_papier'=> 10,
            'quantite_dechets_canette'=> 40,

            'quantite_plastique_mensuel'=>5000,
            'quantite_composte_mensuel'=> 2500,
            'quantite_papier_mensuel'=> 2300,
            'quantite_canette_mensuel'=> 3400,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'camion_id'=>1,
            'nom_etablissement'=> 'reschool',
            'type_etablissement'=> 'privee',
            'niveau_etablissement'=>'ecole primaire',
            'nbr_personnes'=> 2500,
            'url_map'=> 'https://goo.gl/maps/JThJ4X5Ccuk1TDVz9',
            'adresse'=> '42 Rue 8603  Charguia 1 2035 Tunis',
            'longitude'=> 10.205499186074000000000000000,
            'latitude'=> 36.841488984544000000000000000,
            'quantite_dechets_plastique'=>20,
            'quantite_dechets_composte'=> 200,
            'quantite_dechets_papier'=> 10,
            'quantite_dechets_canette'=> 40,

            'quantite_plastique_mensuel'=>8000,
            'quantite_composte_mensuel'=> 6500,
            'quantite_papier_mensuel'=> 5300,
            'quantite_canette_mensuel'=> 5400,
        ]);

        $etablissement=\App\Models\Etablissement::get();
        foreach ($etablissement as $etab){
            Bloc_etablissement::create([
                'etablissement_id'=> $etab->id,
                'nom_bloc_etablissement'=>'A',
            ]);
            Bloc_etablissement::create([
                'etablissement_id'=> $etab->id,
                'nom_bloc_etablissement'=>'B',
            ]);
            Bloc_etablissement::create([
                'etablissement_id'=> $etab->id,
                'nom_bloc_etablissement'=>'C',
            ]);
        }
        $bloc_etablissement=\App\Models\Bloc_etablissement::get();
        foreach ($bloc_etablissement as $b_etab){
            for ($e = 0; $e<3; $e++) {
                Etage_etablissement::create([
                    'bloc_etablissement_id'=>$b_etab->id ,
                    'nom_etage_etablissement'=> $e,
                ]);
            }
        }

        $etage_etablissement=\App\Models\Etage_etablissement::get();
        foreach ($etage_etablissement as $etage){
                Bloc_poubelle::create([
                    'etage_etablissement_id'=> $etage->id,
                ]);
                Bloc_poubelle::create([
                    'etage_etablissement_id'=> $etage->id,
                ]);
        }

        $bloc_poubelle=\App\Models\Bloc_poubelle::get();
        $pid=1;
        foreach ($bloc_poubelle as $bl_pou){
            $etage= Etage_etablissement::where('id',$bl_pou->etage_etablissement_id)->first();

            $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();

            $etabl= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
            $poubelles=[
                ['plastique','PL',$pid],
                ['papier','PA',$pid+1],
                ['composte','CO',$pid+2],
                ['canette','CA',$pid+3]
            ];
            foreach($poubelles as $poubelle){
                $poubelleNom= $etabl->nom_etablissement.'-'.$bloc_etabl->nom_bloc_etablissement.'-E'.$etage->nom_etage_etablissement.'-BP'.$bl_pou->id.'-N'.$poubelle[2];
                $qrcode= Hash::make($poubelleNom);
              Poubelle::create([
                'bloc_poubelle_id'=>$bl_pou->id,
                'nom'=>$poubelleNom,
                'qrcode' => $qrcode,
                'type'=>$poubelle[0],
                'Etat'=>rand(0.1, 1000) / 10,
            ]);
          }
          $pid=$pid+4;
        }
        Responsable_etablissement::create([
            'etablissement_id'=>1,
            'nom'=> 'foulen',
            'prenom'=> 'ben foulen',
            'photo'=> 'responsable.png',
            'numero_telephone'=> 21548796,
            'numero_fixe'=> 231211224,
            'email'=> 'responsable1.reschool@gmail.com',
            'adresse'=> 'adresse responsable etablissement',
            'mot_de_passe'=> Hash::make('responsable1'),
            'QRcode'=> Hash::make('responsable1.reschool@gmail.com'),
        ]);
        Responsable_etablissement::factory(7)->create();
    }
}
