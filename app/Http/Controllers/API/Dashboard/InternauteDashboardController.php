<?php
namespace App\Http\Controllers\API\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Camion;
use App\Models\Commande_dechet;
use App\Models\Depot;
use App\Models\Etablissement;
use App\Models\Ouvrier;
use App\Models\Poubelle;
use App\Models\Zone_depot;
use App\Models\Zone_travail;

class InternauteDashboardController extends Controller
{
    public function dashbordInternaute(){
        $nbr_zone_travail= Zone_travail::all()->count();
        $nbr_etablissement= Etablissement::all()->count();

        $nbr_poubelle_vendus= Poubelle::all()->count();
        $nbr_zone_depot= Zone_depot::all()->count();
        $nbr_camion= Camion::all()->count();

        $nbr_ouvrier= Ouvrier::all()->count();

        $qt_dechet_plastique= Zone_depot::all()->sum("quantite_depot_actuelle_plastique");
        $qt_dechet_papier=  Zone_depot::all()->sum("quantite_depot_actuelle_papier");
        $qt_dechet_canette=  Zone_depot::all()->sum("quantite_depot_actuelle_canette");
        $qt_dechet_composte=  Zone_depot::all()->sum("quantite_depot_actuelle_composte");


        $myArray = [
            'qt_dechet_plastique'=>round($qt_dechet_plastique  * 1000) / 1000,
            'qt_dechet_papier'=>round($qt_dechet_papier  * 1000) / 1000,
            'qt_dechet_canette'=>round($qt_dechet_canette  * 1000) / 1000,
            'qt_dechet_composte'=>round($qt_dechet_composte  * 1000) / 1000,
            'nbr_zone_travail'=>$nbr_zone_travail,
            'nbr_etablissement'=>$nbr_etablissement,
            'nbr_poubelle_vendus'=>$nbr_poubelle_vendus,
            'nbr_ouvrier'=>$nbr_ouvrier,
            'nbr_zone_depot'=>$nbr_zone_depot,
            'nbr_camion'=>$nbr_camion,
        ];
        return response()->json($myArray);
    }

}
