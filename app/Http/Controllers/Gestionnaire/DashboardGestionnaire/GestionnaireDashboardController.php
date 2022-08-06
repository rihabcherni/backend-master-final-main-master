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
use Carbon\Carbon;

class GestionnaireDashboardController extends Controller{
    public function dashbordValeur(){
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

    public function pannes (){
        $nbr_panne_poubelle= Reparation_poubelle::all()->count();
        $nbr_poubelle= Poubelle::all()->count();
        if($nbr_poubelle!=0){$pourcentage_panne_poubelle=$nbr_panne_poubelle/$nbr_poubelle;
        }else {$pourcentage_panne_poubelle=0;}

        $nbr_panne_camion= Reparation_camion::all()->count();
        $nbr_camion= Camion::all()->count();
        if($nbr_camion!=0){$pourcentage_panne_camion=$nbr_panne_camion/$nbr_camion;
        }else {$pourcentage_panne_camion=0;}
        $cout_panne_camions= Reparation_camion::all()->sum('cout');
        $cout_panne_poubelles= Reparation_poubelle::all()->sum('cout');
        $moy_cout_panne_poubelles= Reparation_poubelle::all()->avg('cout');
        $moy_cout_panne_camions= Reparation_camion::all()->avg('cout');
        $max_cout_panne_poubelles= Reparation_poubelle::all()->max('cout');
        $max_cout_panne_camions= Reparation_camion::all()->max('cout');
        $min_cout_panne_poubelles= Reparation_poubelle::all()->min('cout');
        $min_cout_panne_camions= Reparation_camion::all()->min('cout');
        /**************************************************      camion     ****************************************************************** */
        $CamionPanneDiff=[];
        $date_debutPanneCamion = Reparation_camion::get()->toArray();
        foreach ($date_debutPanneCamion as $data){
            $day= Carbon::parse($data['date_fin_reparation'])->diffInDays( Carbon::parse($data['date_debut_reparation']));
            array_push($CamionPanneDiff, array_merge($data,['nbr_jours'=>$day]));
        }
        $max_duree_panne_camion = collect($CamionPanneDiff)->max('nbr_jours');
        $min_duree_panne_camion = collect($CamionPanneDiff)->min('nbr_jours');
        $sum_duree_panne_camion = collect($CamionPanneDiff)->sum('nbr_jours');
        $moy_duree_panne_camion = collect($CamionPanneDiff)->avg('nbr_jours');

        $top_panne_camion_nbr_jours = collect($CamionPanneDiff)->sortByDesc('nbr_jours')->values()->take(3);
        $top_panne_camion_cout = collect($CamionPanneDiff)->sortByDesc('cout')->values()->take(3);

        /**************************************************      camion     ****************************************************************** */

        /**************************************************      poubelle     ****************************************************************** */

        $PoubellePanneDiff=[];
        $date_debutPannePoubelle = Reparation_poubelle::get()->toArray();
        foreach ($date_debutPannePoubelle as $data){
            $daypoubelle= Carbon::parse($data['date_fin_reparation'])->diffInDays( Carbon::parse($data['date_debut_reparation']));
            array_push($PoubellePanneDiff, array_merge($data,['nbr_jours'=>$daypoubelle]));
        }
        $max_duree_panne_poubelle = collect($PoubellePanneDiff)->max('nbr_jours');
        $min_duree_panne_poubelle = collect($PoubellePanneDiff)->min('nbr_jours');
        $sum_duree_panne_poubelles = collect($PoubellePanneDiff)->sum('nbr_jours');
        $moy_duree_panne_poubelles = collect($PoubellePanneDiff)->avg('nbr_jours');


        $top_panne_poubelles_nbr_jours = collect($PoubellePanneDiff)->sortByDesc('nbr_jours')->values()->take(3);
        $top_panne_poubelles_cout = collect($PoubellePanneDiff)->sortByDesc('cout')->values()->take(3);

        /**************************************************      poubelle     ****************************************************************** */
        $myArray = [
            'cout_total_panne'=>$cout_panne_poubelles+$cout_panne_camions,
            'duree_total_panne'=>$sum_duree_panne_poubelles+$sum_duree_panne_camion,
            'nbr_panne_poubelle'=>$nbr_panne_poubelle,
            'pourcentage_panne_poubelle'=>round($pourcentage_panne_poubelle  * 10000) / 10000,
            'cout_panne_poubelles'=>$cout_panne_poubelles,
            'moy_cout_panne_poubelles'=>round($moy_cout_panne_poubelles  * 1000) / 1000,
            'max_cout_panne_poubelles'=>$max_cout_panne_poubelles,
            'min_cout_panne_poubelles'=>$min_cout_panne_poubelles,
            'max_duree_panne_poubelle'=>$max_duree_panne_poubelle,
            'min_duree_panne_poubelle'=>$min_duree_panne_poubelle,
            'sum_duree_poubelles'=>$sum_duree_panne_poubelles,
            'moy_duree_poubelles'=>round($moy_duree_panne_poubelles  * 100) / 100,

            'top_panne_poubelles_nbr_jours'=>$top_panne_poubelles_nbr_jours,
            'top_panne_poubelles_cout'=>$top_panne_poubelles_cout,


            'nbr_panne_camion'=>$nbr_panne_camion,
            'pourcentage_panne_camion'=> round($pourcentage_panne_camion  * 10000) / 10000,
            'cout_panne_camions'=>$cout_panne_camions,
            'moy_cout_panne_camions'=>round($moy_cout_panne_camions  * 1000) / 1000,
            'max_cout_panne_camions'=>$max_cout_panne_camions,
            'min_cout_panne_camions'=>$min_cout_panne_camions,

            'max_duree_panne_camion'=>$max_duree_panne_camion,
            'min_duree_panne_camion'=>$min_duree_panne_camion,
            'sum_duree_camion'=>$sum_duree_panne_camion,
            'moy_duree_camion'=>round($moy_duree_panne_camion  * 100) / 100,

            'top_panne_camion_nbr_jours'=>$top_panne_camion_nbr_jours,
            'top_panne_camion_cout'=>$top_panne_camion_cout,

        ];
        return response()->json($myArray);
    }
    public function PannesPoubelleAnnees(){
        $year = Reparation_poubelle::selectRaw('year(date_debut_reparation) as year')->groupBy('year')->orderByRaw('min(date_debut_reparation) desc')->get();
            $an=[];
            for ($j=0;$j<$year->count();$j++) {
                array_push($an,$year[$j]['year']);
            }
            $panne_poubelle_annee = Reparation_poubelle::selectRaw('year(date_debut_reparation) as year,
                count(id) as nbr,
                sum(cout) as cout'
            ) ->groupBy('year')
                ->orderByRaw('min(date_debut_reparation) desc')
                ->get();
                $myArray = [
                    'annee'=>$year,
                    'data'=>$panne_poubelle_annee,
                ];
                return response()->json($myArray);
    }

    public function PannesCamionAnnees(){
            $year = Reparation_camion::selectRaw('year(date_debut_reparation) as year')->groupBy('year')
            ->orderByRaw('min(date_debut_reparation) desc')->get();
            $an=[];
            for ($j=0;$j<$year->count();$j++) {
                array_push($an,$year[$j]['year']);
            }
            $panne_camion_annee = Reparation_camion::selectRaw('year(date_debut_reparation) as year,
                count(id) as nbr,
                sum(cout) as cout'
            ) ->groupBy('year')
                ->orderByRaw('min(date_debut_reparation) desc')
                ->get();
                $myArray = [
                    'annee'=>$an,
                    'data'=>$panne_camion_annee,
                ];
                return response()->json($myArray);
    }

    public function PanneCamionparMois(){
        $year = Reparation_camion::selectRaw('year(date_debut_reparation) as year')
            ->groupBy('year')->orderByRaw('min(date_debut_reparation) desc')->get();
        $an=[];
        for ($j=0;$j<$year->count();$j++) {array_push($an,$year[$j]['year']);}
        $nbr_camion = Reparation_camion::selectRaw('year(date_debut_reparation) as year, month(date_debut_reparation) as month,
        ifnull(count(id),0) as nbr_panne_camion, ifnull(sum(cout),0) as cout
            ')->groupBy('year','month')->orderByRaw('min(date_debut_reparation) desc')->get();
        $nbr_camion_panne=[];
        $cout_camion_panne=[];
        for ($j=0;$j<count($an);$j++) {
            $nb_camion= [0,0,0,0,0,0,0,0,0,0,0,0];
            $cout= [0,0,0,0,0,0,0,0,0,0,0,0];
            for($i=12;$i>=1;$i--){
                for ($t=0;$t<$nbr_camion->count();$t++){
                    if($nbr_camion[$t]['year']===$an[$j]){
                        if( $nbr_camion[$t]['month'] ===$i){
                            $nb_camion[$nbr_camion[$t]['month']-1]=$nbr_camion[$t]['nbr_panne_camion'];
                            $cout[$nbr_camion[$t]['month']-1]=$nbr_camion[$t]['cout'];
                        }
                    }
                }
            }
        array_push($nbr_camion_panne, $nb_camion);
        array_push($cout_camion_panne,$cout);
        }
        $myArray = ['annee'=>$an,'nbr'=>$nbr_camion_panne,'cout'=>$cout_camion_panne,];
        return response()->json($myArray);
    }

    public function PannePoubelleparMois(){
        $year = Reparation_poubelle::selectRaw('year(date_debut_reparation) as year')
            ->groupBy('year')->orderByRaw('min(date_debut_reparation) desc')->get();
        $an=[];
        for ($j=0;$j<$year->count();$j++) {array_push($an,$year[$j]['year']); }
        $nbr_poubelle = Reparation_poubelle::selectRaw('year(date_debut_reparation) as year, month(date_debut_reparation) as month,
            ifnull(count(id),0) as nbr_panne_poubelle, ifnull(sum(cout),0) as cout')->groupBy('year','month')->orderByRaw('min(date_debut_reparation) desc')->get();
        $nbr_poubelle_panne=[];
        $cout_poubelle_panne=[];
        for ($j=0;$j<count($an);$j++) {
            $nb_poubelle= [0,0,0,0,0,0,0,0,0,0,0,0];
            $cout= [0,0,0,0,0,0,0,0,0,0,0,0];
            for($i=12;$i>=1;$i--){
                for ($t=0;$t<$nbr_poubelle->count();$t++){
                    if($nbr_poubelle[$t]['year']===$an[$j]){
                        if( $nbr_poubelle[$t]['month'] ===$i){
                            $nb_poubelle[$nbr_poubelle[$t]['month']-1]=$nbr_poubelle[$t]['nbr_panne_poubelle'];
                            $cout[$nbr_poubelle[$t]['month']-1]=$nbr_poubelle[$t]['cout'];
                        }
                    }
                }
            }
            array_push($nbr_poubelle_panne, $nb_poubelle);
            array_push($cout_poubelle_panne,$cout);
        }
        $myArray = [ 'annee'=>$an,'nbr'=>$nbr_poubelle_panne,'cout'=>$cout_poubelle_panne,];
        return response()->json($myArray);
    }
}

