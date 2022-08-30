<?php
namespace Database\Seeders;
use App\Models\Camion;
use App\Models\Client_dechet;
use App\Models\Gestionnaire;
use App\Models\Mecanicien;
use App\Models\Ouvrier;
use App\Models\Reparateur_poubelle;
use App\Models\Responsable_commercial;
use App\Models\Responsable_personnel;
use App\Models\Responsable_technique;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompteSeeder extends Seeder{
    public function run(){
        Gestionnaire::create([
            'nom'=> 'gestionnaire',
            'prenom'=> 'reschool',
            'photo'=>'gestionnaire1.jpg',
            'CIN'=> 125411222,
            'numero_telephone'=> 23657412,
            'email'=> 'gestionnaire1.reschool@gmail.com',
            'adresse'=> 'adresse gestionnaire',
            'mot_de_passe'=> Hash::make('gestionnaire1'),
            'QRcode'=> Hash::make('gestionnaire1.reschool@gmail.com'),
        ]);
        Camion::create([
            'zone_travail_id'=> 1,
            'zone_depot_id'=> 1,
            'matricule' =>'125 tunis 201',
            'QRcode' => Hash::make(Str::random(10)),
            'latitude'=> 36.87885 ,
            'longitude'=>10.23284,
            'volume_maximale_camion'=>2000,
            'volume_actuelle_plastique'=>0,
            'volume_actuelle_papier'=> 0,
            'volume_actuelle_composte'=>0,
            'volume_actuelle_canette'=> 0,
            'volume_carburant_consomme'=>0,
            'Kilometrage'=>0,
        ]);
        Ouvrier::create([
            'camion_id'=> 1,
            'poste'=> 'conducteur',
            'photo'=>'ouvrier.png',
            'QRcode' => Hash::make('ouvrier1'),
            'nom'=> 'Samir',
            'prenom'=> 'Ben salah',
            'CIN'=> 12475555,
            'numero_telephone'=> 55875252,
            'email'=> 'ouvrier1.reschool@gmail.com',
            'adresse'=> 'adresse ouvrier',
            'mot_de_passe'=> Hash::make('ouvrier1'),
        ]);
        Ouvrier::create([
            'camion_id'=> 1,
            'photo'=>'ouvrier2.png',
            'poste'=> 'agent',
            'QRcode' => Hash::make('ouvrier2'),
            'nom'=> 'Ahmed',
            'prenom'=> 'Ben ahmed',
            'CIN'=> 12475855,
            'numero_telephone'=> 45212154,
            'email'=> 'ouvrier2.reschool@gmail.com',
            'adresse'=> 'adresse ouvrier 2',
            'mot_de_passe'=> Hash::make('ouvrier2'),
        ]);
        Client_dechet::create([
            'nom_entreprise'=> 'reschool',
            'nom'=> 'foulen',
            'prenom'=> 'ben foulen',
            'matricule_fiscale'=> 21548796,
            'numero_telephone'=> 421211224,
            'numero_fixe'=> 421231224,
            'email'=> 'client1.reschool@gmail.com',
            'adresse'=> 'adresse client dechet',
            'mot_de_passe'=> Hash::make('client-dechet1'),
            'QRcode'=> Hash::make('client1.reschool@gmail.com'),
        ]);
        Responsable_commercial::create([
            'nom'=> 'responsable',
            'prenom'=> 'commerciale',
            'numero_telephone'=> 45225514,
            'CIN'=> 154554444,
            'email'=> 'responsable-comm1.reschool@gmail.com',
            'photo'=>'responsable_commerciale.jpg',
            'mot_de_passe'=> Hash::make('responsable-commerciale1'),
            'QRcode'=> Hash::make('responsable-comm1.reschool@gmail.com'),
        ]);
        Responsable_personnel::create([
            'nom'=> 'responsable',
            'prenom'=> 'personnel',
            'numero_telephone'=> 544122121,
            'CIN'=> 1254214,
            'email'=> 'responsable-pers1.reschool@gmail.com',
            'photo'=>'responsable_personnel.jpg',
            'mot_de_passe'=> Hash::make('responsable-personnel1'),
            'QRcode'=> Hash::make('responsable-pers1.reschool@gmail.com'),
        ]);
        Responsable_technique::create([
            'nom'=> 'responsable',
            'prenom'=> 'technique',
            'numero_telephone'=> 4545454,
            'CIN'=> 7564221,
            'Adresse'=> 'adresse responsable technique',
            'email'=> 'responsable-technique1.reschool@gmail.com',
            'photo'=>'responsable_technique.jpg',
            'mot_de_passe'=> Hash::make('responsable-technique1'),
            'QRcode'=> Hash::make('responsable-technique1.reschool@gmail.com'),
        ]);
        Mecanicien::create([
            'nom'=> 'nom mecanicien',
            'prenom'=> 'prenom mecanicien',
            'numero_telephone'=> 455322222,
            'CIN'=> 6552323,
            'Adresse'=> 'adresse mecanicien',
            'email'=> 'mecanicien1.reschool@gmail.com',
            'photo'=>'mecanicien.jpg',
            'mot_de_passe'=> Hash::make('mecanicien1'),
            'QRcode'=> Hash::make('mecanicien1.reschool@gmail.com'),
        ]);
        Reparateur_poubelle::create([
            'nom'=> 'reparateur',
            'prenom'=> 'poubelle',
            'numero_telephone'=> 5454452121,
            'CIN'=> 5442010,
            'Adresse'=> 'adresse reparateur poubelle',
            'email'=> 'reparateur-poubelle1.reschool@gmail.com',
            'photo'=>'reparateur_poubelle.jpg',
            'mot_de_passe'=> Hash::make('reparateur-poubelle1'),
            'QRcode'=> Hash::make('reparateur-poubelle1.reschool@gmail.com'),
        ]);
    }
}
