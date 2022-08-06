<?php

namespace App\Http\Controllers\Globale;

use App\Http\Controllers\Globale\Controller;
use App\Models\Commande_dechet;
use App\Models\Dechet;
use App\Models\Zone_depot;
use App\Models\Zone_travail;
use App\Models\Depot;
use App\Models\Detail_commande_dechet;

class SommeDechetController extends Controller{
    public function SommeDechetZoneDepot(){
        $myArray = [
            'somme_depot_actuelle_plastique'=>round(Zone_depot::sum("quantite_depot_actuelle_plastique")* 1000)/1000,
            'somme_depot_actuelle_papier'=>round(Zone_depot::sum("quantite_depot_actuelle_papier")* 1000)/1000,
            'somme_depot_actuelle_composte'=>round(Zone_depot::sum("quantite_depot_actuelle_composte")* 1000)/1000,
            'somme_depot_actuelle_canette'=>round(Zone_depot::sum("quantite_depot_actuelle_canette")* 1000)/1000,
        ];
        return $myArray;
    }
    public function StockDechetActuelle(){
        $plastique_tot=Zone_depot::sum("quantite_depot_actuelle_plastique");
        $papier_tot=Zone_depot::sum("quantite_depot_actuelle_papier");
        $composte_tot=Zone_depot::sum("quantite_depot_actuelle_composte");
        $canette_tot=Zone_depot::sum("quantite_depot_actuelle_canette");

        $plastique_achette=Detail_commande_dechet::where('dechet_id',1)->sum("quantite");
        $papier_achette=Detail_commande_dechet::where('dechet_id',3)->sum("quantite");
        $composte_achette=Detail_commande_dechet::where('dechet_id',2)->sum("quantite");
        $canette_achette=Detail_commande_dechet::where('dechet_id',4)->sum("quantite");

        $myArray = [
            'somme_depot_actuelle_plastique'=>round( ($plastique_tot -$plastique_achette)* 1000)/1000,
            'somme_depot_actuelle_papier'=>round( ($papier_tot-$papier_achette )* 1000)/1000,
            'somme_depot_actuelle_composte'=>round(($composte_tot- $composte_achette) * 1000)/1000,
            'somme_depot_actuelle_canette'=>round(($canette_tot - $canette_achette) * 1000)/1000,
        ];
        return $myArray;
    }
    public function SommeDechetZoneTravail(){
        $myArray = [
            'quantite_total_collecte_plastique'=>Zone_travail::sum("quantite_total_collecte_plastique"),
            'quantite_total_collecte_composte'=>Zone_travail::sum("quantite_total_collecte_composte"),
            'quantite_total_collecte_papier'=>Zone_travail::sum("quantite_total_collecte_papier"),
            'quantite_total_collecte_canette'=>Zone_travail::sum("quantite_total_collecte_canette"),
        ];
        return response()->json($myArray);
    }

    public function PrixDechets(){
        $myArray = [
            'prix_plastique'=> Dechet::where("type_dechet","plastique")->value("prix_unitaire"),
            'prix_papier'=> Dechet::where("type_dechet","papier")->value("prix_unitaire"),
            'prix_composte'=> Dechet::where("type_dechet","composte")->value("prix_unitaire"),
            'prix_canette'=> Dechet::where("type_dechet","canette")->value("prix_unitaire"),
        ];
        return response()->json($myArray);
    }

    public function QuantiteDechetTotaleClient(){
        $client=auth()->guard('client_dechet')->user();
        $commande=Commande_dechet::where('client_dechet_id',$client->id)->pluck("id");
        $myArray = [
            'quantite_total_achetee_plastique'=>Detail_commande_dechet::whereIn('commande_dechet_id',$commande )->where('dechet_id',1)->sum("quantite"),
            'quantite_total_achetee_composte'=>Detail_commande_dechet::whereIn('commande_dechet_id',$commande )->where('dechet_id',2)->sum("quantite"),
            'quantite_total_achetee_papier'=>Detail_commande_dechet::whereIn('commande_dechet_id',$commande )->where('dechet_id',3)->sum("quantite"),
            'quantite_total_achetee_canette'=>Detail_commande_dechet::whereIn('commande_dechet_id',$commande )->where('dechet_id',4)->sum("quantite"),
        ];
        return response()->json($myArray);
      }

    public function SommeDechetsVendus(){
        $year = Detail_commande_dechet::selectRaw('year(created_at) as year')
            ->groupBy('year')
            ->orderByRaw('min(created_at) desc')
            ->get();
        $sommeplastique = Detail_commande_dechet::selectRaw('year(created_at) as year, month(created_at) as month,
        ifnull(sum(quantite),0) as quantite_vendu_plastique')
            ->groupBy('year','month')
            ->where('dechet_id',1)
            ->orderByRaw('min(created_at) desc')
            ->get();
        $sommepapier = Detail_commande_dechet::selectRaw('year(created_at) as year, month(created_at) as month,
        ifnull(sum(quantite),0) as quantite_vendu_papier')
            ->groupBy('year','month')
            ->where('dechet_id',2)
            ->orderByRaw('min(created_at) desc')
            ->get();
        $sommecomposte = Detail_commande_dechet::selectRaw('year(created_at) as year, month(created_at) as month,
        ifnull(sum(quantite),0) as quantite_vendu_composte')
            ->groupBy('year','month')
            ->where('dechet_id',3)
            ->orderByRaw('min(created_at) desc')
            ->get();
        $sommecanette = Detail_commande_dechet::selectRaw('year(created_at) as year, month(created_at) as month,
        ifnull(sum(quantite),0) as quantite_vendu_canette')
            ->groupBy('year','month')
            ->where('dechet_id',4)
            ->orderByRaw('min(created_at) desc')
            ->get();
        $ventes_plastique=[];
        $ventes_papier=[];
        $ventes_composte=[];
        $ventes_canette=[];

        for ($j=0;$j<$year->count();$j++) {
            $plastique= [0,0,0,0,0,0,0,0,0,0,0,0];
            $papier= [0,0,0,0,0,0,0,0,0,0,0,0];
            $composte= [0,0,0,0,0,0,0,0,0,0,0,0];
            $canette= [0,0,0,0,0,0,0,0,0,0,0,0];
            for($i=12;$i>=1;$i--){
                for ($t=0; $t<$sommeplastique->count() ; $t++){
                    if($sommeplastique[$t]['year']===$year[$j]['year']){
                        if( $sommeplastique[$t]['month'] ===$i){
                            $plastique[$sommeplastique[$t]['month']-1]=$sommeplastique[$t]['quantite_vendu_plastique'];
                        }
                    }
                }
                for ($t=0; $t<$sommepapier->count() ; $t++){
                    if($sommepapier[$t]['year']===$year[$j]['year']){
                        if( $sommepapier[$t]['month'] ===$i){
                            $papier[$sommepapier[$t]['month']-1]=$sommepapier[$t]['quantite_vendu_papier'];
                        }
                    }
                }
                for ($t=0; $t<$sommecomposte->count() ; $t++){
                    if($sommecomposte[$t]['year']===$year[$j]['year']){
                        if( $sommecomposte[$t]['month'] ===$i){
                            $composte[$sommecomposte[$t]['month']-1]=$sommecomposte[$t]['quantite_vendu_composte'];
                        }
                    }
                }
                for ($t=0; $t<$sommecanette->count() ; $t++){
                    if($sommecanette[$t]['year']===$year[$j]['year']){
                        if( $sommecanette[$t]['month'] ===$i){
                            $canette[$sommecanette[$t]['month']-1]=$sommecanette[$t]['quantite_vendu_canette'];
                        }
                    }
                }
            }
            array_push($ventes_plastique, $plastique);
            array_push($ventes_papier, $papier);
            array_push($ventes_composte, $composte);
            array_push($ventes_canette, $canette);
        }
        $somme_totale_plastique= 0 ;
        $somme_totale_papier= 0 ;
        $somme_totale_canette= 0 ;
        $somme_totale_composte= 0 ;

        for($x=0 ; $x<$year->count() ; $x++){
            for($y=0 ; $y<$sommeplastique->count() ; $y++){
                for($z=0 ; $z<=11 ; $z++){
                    $somme_totale_plastique = $somme_totale_plastique + $ventes_plastique[$y][$z];
                    $somme_totale_papier = $somme_totale_papier + $ventes_papier[$y][$z];
                    $somme_totale_canette = $somme_totale_canette + $ventes_canette[$y][$z];
                    $somme_totale_composte = $somme_totale_composte + $ventes_composte[$y][$z];
                }
            }
        }
        $an=[];
        for ($j=0;$j<$year->count();$j++) {
            array_push($an,$year[$j]['year']);
        }
        $myArray = [
            'annee'=>$an,
            'plastique'=>$ventes_plastique,
            'papier'=>$ventes_papier,
            'composte'=>$ventes_composte,
            'canette'=>$ventes_canette,
            'somme_totale_plastique'=>$somme_totale_plastique,
            'somme_totale_papier'=>$somme_totale_papier,
            'somme_totale_canette'=>$somme_totale_canette,
            'somme_totale_composte'=>$somme_totale_composte,
        ];
        return response()->json($myArray);
    }
    public function sommeDechetsDepotparMois(){
        $year = Depot::selectRaw('year(date_depot) as year')
            ->groupBy('year')
            ->orderByRaw('min(date_depot) desc')
            ->get();
        $somme = Depot::selectRaw('year(date_depot) as year, month(date_depot) as month,
        ifnull(sum(quantite_depose_plastique),0) as quantite_depose_plastique,
        ifnull(sum(quantite_depose_papier),0) as quantite_depose_papier,
        ifnull(sum(quantite_depose_composte),0) as quantite_depose_composte,
        ifnull(sum(quantite_depose_canette),0)  as quantite_depose_canette')
            ->groupBy('year','month')
            ->orderByRaw('min(date_depot) desc')
            ->get();
        $mat_plastique=[];
        $mat_papier=[];
        $mat_composte=[];
        $mat_canette=[];

        for ($j=0;$j<$year->count();$j++) {
            $plastique= [0,0,0,0,0,0,0,0,0,0,0,0];
            $papier= [0,0,0,0,0,0,0,0,0,0,0,0];
            $composte= [0,0,0,0,0,0,0,0,0,0,0,0];
            $canette= [0,0,0,0,0,0,0,0,0,0,0,0];
            for($i=12;$i>=1;$i--){
                for ($t=0;$t<$somme->count();$t++){
                    if($somme[$t]['year']===$year[$j]['year']){
                        if( $somme[$t]['month'] ===$i){
                            $plastique[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique'];
                            $papier[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier'];
                            $composte[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte'];
                            $canette[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette'];
                        }
                    }
                }
            }
            array_push($mat_plastique, $plastique);
            array_push($mat_papier, $papier);
            array_push($mat_composte, $composte);
            array_push($mat_canette, $canette);
        }

        $an=[];
        for ($j=0;$j<$year->count();$j++) {
            array_push($an,$year[$j]['year']);
        }
        $myArray = [
            'annee'=>$an,
            'plastique'=>$mat_plastique,
            'papier'=>$mat_papier,
            'composte'=>$mat_composte,
            'canette'=>$mat_canette,
        ];
        return response()->json($myArray);
    }

    public function sommeDechetAnnees(){
        $somme = Depot::selectRaw('year(date_depot) as year,
            sum(quantite_depose_plastique) as quantite_depose_plastique,
            sum(quantite_depose_papier) as quantite_depose_papier,
            sum(quantite_depose_composte) as quantite_depose_composte,
            sum(quantite_depose_canette) as quantite_depose_canette'
        )
            ->groupBy('year')
            ->orderByRaw('min(date_depot) desc')
            ->get();
            return response()->json($somme);
    }

      // public function SommeDechetBlocEtablissement($etablissement_id){

    //     $bloc_poubelle = Bloc_poubelle::where('etablissement_id',$etablissement_id)->get();
    //     $quantite_total_collecte_plastique= Etablissement::sum("quantite_total_collecte_plastique");
    //     $quantite_total_collecte_composte= Etablissement::sum("quantite_total_collecte_composte");
    //     $quantite_total_collecte_papier= Etablissement::sum("quantite_total_collecte_papier");
    //     $quantite_total_collecte_canette= Etablissement::sum("quantite_total_collecte_canette");

    //     $myArray = [
    //         $bloc_poubelle,
    //         'quantite_total_collecte_plastique'=>$quantite_total_collecte_plastique,
    //         'quantite_total_collecte_composte'=>$quantite_total_collecte_composte,
    //         'quantite_total_collecte_papier'=>$quantite_total_collecte_papier,
    //         'quantite_total_collecte_canette'=>$quantite_total_collecte_canette,
    //     ];
    //     return response()->json($myArray);
    // }
}
