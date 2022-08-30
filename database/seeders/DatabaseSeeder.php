<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{ Gestionnaire,Fournisseur,Client_dechet,Mecanicien,Reparateur_poubelle,Ouvrier
    ,Commande_dechet,Depot, Materiau_primaire,Reparation_camion,
    Reparation_poubelle, Responsable_technique, Vider_poubelle, Zone_depot};

class DatabaseSeeder extends Seeder{
    public function run(){
        $this->call([
            ZoneTravailSeeder::class,
            DechetSeeder::class,
            EtablissementSeeder::class,
            StockPoubelleSeeder::class,
            CompteSeeder::class,
        ]);

        Gestionnaire::factory(5)->create();
        Fournisseur::factory(5)->create();
        Client_dechet::factory(5)->create();
        Responsable_technique::factory(5)->create();
        Mecanicien::factory(5)->create();
        Reparateur_poubelle::factory(5)->create();

        Ouvrier::factory(20)->create();

        Reparation_camion::factory(5)->create();
        Reparation_poubelle::factory(10)->create();
        Materiau_primaire::factory(5)->create();

        Depot::factory(15)->create();
        Vider_poubelle::factory(80)->create();

        Commande_dechet::factory(10)->create();
    }
}
