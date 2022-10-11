<?php

namespace App\Http\Controllers\ClientDechet;
use App\Http\Controllers\Globale\Controller;
use App\Models\Commande_dechet;
use App\Http\Resources\GestionDechet\Commande_dechet as Commande_dechetResource;
use App\Models\Zone_depot;
use App\Models\Zone_travail;

class DashboradClientDechetController extends Controller{
    public function HistoriqueCommandeClient(){
        $client=auth()->guard('client_dechet')->user();
        $commande= Commande_dechet::where('client_dechet_id',$client->id)->get();
        return Commande_dechetResource::collection($commande);
    }
    public function Top3PrixCommandeClient(){
        $client=auth()->guard('client_dechet')->user();
        $commande= Commande_dechet::where('client_dechet_id','=',$client->id)->orderBy('montant_total','desc')->take(3)->get();
        return Commande_dechetResource::collection($commande);
    }
    public function Last3CommandeClient(){
        $client=auth()->guard('client_dechet')->user();
        $commande= Commande_dechet::where('client_dechet_id','=',$client->id)->orderBy('date_commande','desc')->take(3)->get();
        return Commande_dechetResource::collection($commande);
    }
    public function SansLivraisonCommandeClient(){
        $client=auth()->guard('client_dechet')->user();
        $commande= Commande_dechet::where('client_dechet_id','=',$client->id)->where('date_livraison',null)->get();
        return Commande_dechetResource::collection($commande);
    }
    public function QuantiteDechetAcheteClient(){
        $client=auth()->guard('client_dechet')->user();
        $commande=Commande_dechet::where('client_dechet_id',$client->id)->pluck("id");
        $myArray = [
            'quantite_total_achetee_plastique'=>Commande_dechet::whereIn('id',$commande )->sum("quantite_plastique"),
            'quantite_total_achetee_composte'=>Commande_dechet::whereIn('id',$commande )->sum("quantite_composte"),
            'quantite_total_achetee_papier'=>Commande_dechet::whereIn('id',$commande )->sum("quantite_papier"),
            'quantite_total_achetee_canette'=>Commande_dechet::whereIn('id',$commande )->sum("quantite_canette"),
        ];
        return response()->json($myArray);
    }
    public function SommeDechetTotaleReschool(){
        $myArray = [
            'quantite_total_collecte_plastique'=>Zone_depot::sum("quantite_depot_actuelle_plastique"),
            'quantite_total_collecte_composte'=>Zone_depot::sum("quantite_depot_actuelle_composte"),
            'quantite_total_collecte_papier'=>Zone_depot::sum("quantite_depot_actuelle_papier"),
            'quantite_total_collecte_canette'=>Zone_depot::sum("quantite_depot_actuelle_canette"),
        ];
        return response()->json($myArray);
    }

    public function StockDechetActuelle(){
        $plastique_tot=Zone_depot::sum("quantite_depot_actuelle_plastique");
        $papier_tot=Zone_depot::sum("quantite_depot_actuelle_papier");
        $composte_tot=Zone_depot::sum("quantite_depot_actuelle_composte");
        $canette_tot=Zone_depot::sum("quantite_depot_actuelle_canette");

        $plastique_achette=Commande_dechet::sum("quantite_plastique");
        $papier_achette=Commande_dechet::sum("quantite_papier");
        $composte_achette=Commande_dechet::sum("quantite_composte");
        $canette_achette =Commande_dechet::sum("quantite_canette");

        $myArray = [
            'somme_depot_actuelle_plastique'=>round( ($plastique_tot -$plastique_achette)* 1000)/1000,
            'somme_depot_actuelle_papier'=>round( ($papier_tot-$papier_achette )* 1000)/1000,
            'somme_depot_actuelle_composte'=>round(($composte_tot- $composte_achette) * 1000)/1000,
            'somme_depot_actuelle_canette'=>round(($canette_tot - $canette_achette) * 1000)/1000,
        ];
        return $myArray;
    }
    public function QuantiteDechetAcheteparMois(){
        $client=auth()->guard('client_dechet')->user();
        $year = Commande_dechet::where('client_dechet_id',$client->id)->selectRaw('year(date_commande) as year')
            ->groupBy('year')->orderByRaw('min(date_commande) desc')->get();
        $an=[];
        for ($j=0;$j<$year->count();$j++) {array_push($an,$year[$j]['year']);}
        $nbr_commande= Commande_dechet::selectRaw('year(date_commande) as year, month(date_commande) as month,
            ifnull(count(id),0) as nbr_commande,
            ifnull(sum(quantite_plastique),0) as quantite_plastique,
            ifnull(sum(quantite_papier),0) as quantite_papier,
            ifnull(sum(quantite_composte),0) as quantite_composte,
            ifnull(sum(quantite_canette),0) as quantite_canette
        ')->groupBy('year','month')->orderByRaw('min(date_commande) desc')->get();
        $nbr_commande_totale=[];
        $somme_commande_plastique=[];
        $somme_commande_papier=[];
        $somme_commande_composte=[];
        $somme_commande_canette=[];
        for ($j=0;$j<count($an);$j++) {
            $nb_commande= [0,0,0,0,0,0,0,0,0,0,0,0];
            $somme_plastique= [0,0,0,0,0,0,0,0,0,0,0,0];
            $somme_papier= [0,0,0,0,0,0,0,0,0,0,0,0];
            $somme_composte= [0,0,0,0,0,0,0,0,0,0,0,0];
            $somme_canette= [0,0,0,0,0,0,0,0,0,0,0,0];
            for($i=12;$i>=1;$i--){
                for ($t=0;$t<$nbr_commande->count();$t++){
                    if($nbr_commande[$t]['year']===$an[$j]){
                        if( $nbr_commande[$t]['month'] ===$i){
                            $nb_commande[$nbr_commande[$t]['month']-1]=$nbr_commande[$t]['nbr_commande'];
                            $somme_plastique[$nbr_commande[$t]['month']-1]=$nbr_commande[$t]['quantite_plastique'];
                            $somme_papier[$nbr_commande[$t]['month']-1]=$nbr_commande[$t]['quantite_papier'];
                            $somme_composte[$nbr_commande[$t]['month']-1]=$nbr_commande[$t]['quantite_composte'];
                            $somme_canette[$nbr_commande[$t]['month']-1]=$nbr_commande[$t]['quantite_canette'];
                        }
                    }
                }
            }
        array_push($nbr_commande_totale, $nb_commande);
        array_push($somme_commande_plastique,$somme_plastique);
        array_push($somme_commande_papier,$somme_papier);
        array_push($somme_commande_composte,$somme_composte);
        array_push($somme_commande_canette,$somme_canette);
        }
        $myArray = [
            'annee'=>$an,'nbr'=>$nbr_commande_totale,
            'plastique'=>$somme_commande_plastique,
            'papier'=>$somme_commande_papier,
            'composte'=>$somme_commande_composte,
            'canette'=>$somme_commande_canette,
     ];
        return response()->json($myArray);
    }

    public function QuantiteDechetAcheteAnnees(){
        $client=auth()->guard('client_dechet')->user();
        $year = Commande_dechet::where('client_dechet_id',$client->id)->selectRaw('year(date_commande) as year')->
        groupBy('year')
        ->orderByRaw('min(date_commande) desc')->get();
        $an=[];
        for ($j=0;$j<$year->count();$j++) {
            array_push($an,$year[$j]['year']);
        }
        $commande_annee = Commande_dechet::where('client_dechet_id',$client->id)->selectRaw('year(date_commande) as year,
            ifnull(count(id),0) as nbr_commande,
            ifnull(sum(quantite_plastique),0) as quantite_plastique,
            ifnull(sum(quantite_papier),0) as quantite_papier,
            ifnull(sum(quantite_composte),0) as quantite_composte,
            ifnull(sum(quantite_canette),0) as quantite_canette'
        ) ->groupBy('year')
            ->orderByRaw('min(date_commande) desc')
            ->get();
            $myArray = [
                'data'=>$commande_annee,
            ];
            return response()->json($myArray);
}
}
