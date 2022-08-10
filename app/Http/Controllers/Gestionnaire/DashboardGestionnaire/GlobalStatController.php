<?php

namespace App\Http\Controllers\Gestionnaire\DashboardGestionnaire;
use App\Http\Controllers\Globale\Controller;
use App\Models\Bloc_etablissement;
use App\Models\Reparation_poubelle;
use App\Models\Reparation_camion;
use App\Models\Bloc_poubelle;
use App\Models\Camion;
use App\Models\Client_dechet;
use App\Models\Commande_dechet;
use App\Models\Depot;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use App\Models\Fournisseur;
use App\Models\Mecanicien;
use App\Models\Ouvrier;
use App\Models\Poubelle;
use App\Models\Reparateur_poubelle;
use App\Models\Responsable_etablissement;
use App\Models\Stock_poubelle;
use App\Models\Zone_depot;
use App\Models\Zone_travail;
class  GlobalStatController extends Controller{
    public function statGetionnaire(){
        $nbr_zone_travail= Zone_travail::all()->count();
        $nbr_etablissement= Etablissement::all()->count();
        $nbr_bloc_etablissement= Bloc_etablissement::all()->count();
        $nbr_etage_etablissement= Etage_etablissement::all()->count();
        $nbr_bloc_poubelle= Bloc_poubelle::all()->count();
        $nbr_poubelle_vendus= Poubelle::all()->count();

        // $nbr_poubelle_stock= Stock_poubelle::all()->count();
        $nbr_zone_depot= Zone_depot::all()->count();
        $nbr_depot= Depot::all()->count();
        $nbr_camion= Camion::all()->count();


        $nbr_client_dechet= Client_dechet::all()->count();
        $nbr_fournisseur= Fournisseur::all()->count();
        $nbr_ouvrier= Ouvrier::all()->count();
        $nbr_responsable_etablissement= Responsable_etablissement::all()->count();
        $nbr_reparteur_poubelle= Reparateur_poubelle::all()->count();
        $nbr_mecanicien= Mecanicien::all()->count();

        $nbr_panne_poubelle= Reparation_poubelle::all()->count();
        $nbr_panne_camion= Reparation_camion::all()->count();
        $nbr_commande_dechet= Commande_dechet::all()->count();

        $nbr_poubelle_plastique= Stock_poubelle::all()->where("type_poubelle","plastique")->sum("quantite_disponible");
        $nbr_poubelle_papier= Stock_poubelle::all()->where("type_poubelle","papier")->sum("quantite_disponible");
        $nbr_poubelle_composte= Stock_poubelle::all()->where("type_poubelle","composte")->sum("quantite_disponible");
        $nbr_poubelle_canette= Stock_poubelle::all()->where("type_poubelle","canette")->sum("quantite_disponible");

        $qt_dechet_plastique= Zone_depot::all()->sum("quantite_depot_actuelle_plastique");
        $qt_dechet_papier=  Zone_depot::all()->sum("quantite_depot_actuelle_papier");
        $qt_dechet_canette=  Zone_depot::all()->sum("quantite_depot_actuelle_canette");
        $qt_dechet_composte=  Zone_depot::all()->sum("quantite_depot_actuelle_composte");


        $myArray = [
            'nbr_poubelle_plastique'=>$nbr_poubelle_plastique,
            'nbr_poubelle_papier'=>$nbr_poubelle_papier,
            'nbr_poubelle_composte'=>$nbr_poubelle_composte,
            'nbr_poubelle_canette'=>$nbr_poubelle_canette,

            'qt_dechet_plastique'=>round($qt_dechet_plastique  * 1000) / 1000,
            'qt_dechet_papier'=>round($qt_dechet_papier  * 1000) / 1000,
            'qt_dechet_canette'=>round($qt_dechet_canette  * 1000) / 1000,
            'qt_dechet_composte'=>round($qt_dechet_composte  * 1000) / 1000,

            'nbr_zone_travail'=>$nbr_zone_travail,
            'nbr_etablissement'=>$nbr_etablissement,
            'nbr_bloc_etablissement'=>$nbr_bloc_etablissement,
            'nbr_etage_etablissement'=>$nbr_etage_etablissement,
            'nbr_bloc_poubelle'=>$nbr_bloc_poubelle,
            'nbr_poubelle_vendus'=>$nbr_poubelle_vendus,

            // 'nbr_poubelle_stock'=>$nbr_poubelle_stock,
            'nbr_client_dechet'=>$nbr_client_dechet,
            'nbr_responsable_etablissement'=>$nbr_responsable_etablissement,
            'nbr_ouvrier'=>$nbr_ouvrier,
            'nbr_fournisseur'=>$nbr_fournisseur,
            'nbr_mecanicien'=>$nbr_mecanicien,
            'nbr_reparteur_poubelle'=>$nbr_reparteur_poubelle,


            'nbr_zone_depot'=>$nbr_zone_depot,
            'nbr_depot'=>$nbr_depot,
            'nbr_camion'=>$nbr_camion,

            'nbr_panne_camion'=>$nbr_panne_camion,
            'nbr_panne_poubelle'=>$nbr_panne_poubelle,

            'nbr_commande_dechet'=>$nbr_commande_dechet,
        ];
        return response()->json($myArray);
    }
}

