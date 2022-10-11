<?php
namespace App\Http\Controllers\Ouvrier;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Models\Poubelle;
use App\Models\Camion;
use App\Models\Depot;
use App\Models\Zone_depot;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use App\Models\Vider_poubelle;
use App\Models\Zone_travail;

class ViderController extends BaseController{
    public function ViderCamion(){
        $ouvrier=auth()->guard('ouvrier')->user();
        $camion_id = $ouvrier->camion_id;
        $camion = Camion::find($camion_id);

        $zone_depot_id = $camion->zone_depot_id;
        $zone_depot = Zone_depot::find($zone_depot_id);

        $zone_travail_id = $camion->zone_travail_id;
        $zone_travail = Zone_travail::find($zone_travail_id);

        $qt_plastique=$camion->volume_actuelle_plastique;
        $qt_canette=$camion->volume_actuelle_canette;
        $qt_composte=$camion->volume_actuelle_composte;
        $qt_papier=$camion->volume_actuelle_papier;

        $zone_depot->quantite_depot_actuelle_plastique+=$qt_plastique;
        $zone_depot->quantite_depot_actuelle_papier+=$qt_papier;
        $zone_depot->quantite_depot_actuelle_composte+=$qt_composte;
        $zone_depot->quantite_depot_actuelle_canette+=$qt_canette;

        $zone_travail->quantite_total_collecte_plastique+=$qt_plastique;
        $zone_travail->quantite_total_collecte_papier+=$qt_papier;
        $zone_travail->quantite_total_collecte_composte+=$qt_composte;
        $zone_travail->quantite_total_collecte_canette+=$qt_canette;

        $camion->volume_actuelle_plastique=0;
        $camion->volume_actuelle_canette=0;
        $camion->volume_actuelle_composte=0;
        $camion->volume_actuelle_papier=0;

        $camion->save();
        $zone_depot->save();
        $zone_travail->save();
        Depot::create([
           'zone_depot_id'=> $zone_depot_id,
           'camion_id'=> $camion_id,
           'date_depot'=> now(),
           'quantite_depose_plastique'=> $qt_plastique,
           'quantite_depose_composte'=>$qt_composte,
           'quantite_depose_papier'=> $qt_papier,
           'quantite_depose_canette'=>$qt_canette,
        ]);
        $myArray = [
            'zone_depot'=>$zone_depot,
            'zone_travail'=>$zone_travail,
            'camion_id'=>$camion,
            'quantite_plastique_camion'=>$qt_papier,
            'quantite_papier_camion'=>$qt_papier,
            'quantite_composte_camion'=>$qt_composte,
            'quantite_canette_camion'=>$qt_canette,
        ];
        return response()->json($myArray);
    }
    public function ViderPoubelleQr($qr){
        $poubelle = Poubelle::where('nom',$qr)->first();
        if(!$poubelle){
            return response([
                'message' => 'poubelle introuvable'
            ],404);
        }
        $bloc_poubelle = Bloc_poubelle::find($poubelle->bloc_poubelle_id);
        if(!$bloc_poubelle){
            return response([
                'message' => 'bloc poubelle introuvable'
            ],404);
        }
        $etage_etablissement = Etage_etablissement::find($bloc_poubelle->etage_etablissement_id);
        if(!$etage_etablissement){
            return response([
                'message' => 'etage etablissement introuvable'
            ],404);
        }
        $bloc_etablissement = Bloc_etablissement::find($etage_etablissement->bloc_etablissement_id);

        if(!$bloc_etablissement){
            return response([
                'message' => 'bloc_etablissement introuvable'
            ],404);
        }

        $etablissement = Etablissement::find($bloc_etablissement->etablissement_id);
        if(!$etablissement){
            return response([
                'message' => 'etablissement introuvable'
            ],404);
        }
        return response([
            "id"=> $poubelle->id,
            "nom_etablissement"=>$etablissement->nom_etablissement,
            "nom_etage_etablissement"  =>$etage_etablissement->nom_etage_etablissement,
            "nbr_personnes"=>$etablissement->nbr_personnes,
            "nom_bloc_etablissement"=>$bloc_etablissement->nom_bloc_etablissement,
            "nom"=>$poubelle->nom,
            "Etat"=>$poubelle->Etat,
            "type"=>$poubelle->type,
        ]);
    }
    public function VidagePoubelle( $poubelle_id){
        $poubelle = Poubelle::find($poubelle_id);
        $quantite=(config('global.capacite_poubelle')* $poubelle->Etat)/ 100;
        $ouvrier=auth()->guard('ouvrier')->user();
        $camion_id = $ouvrier->camion_id;
        $camion = Camion::find($camion_id);

        $quantite_plastique =0;
        $quantite_papier =0;
        $quantite_composte =0;
        $quantite_canette =0;
        if ($poubelle->type==="plastique"){
            $camion->volume_actuelle_plastique+=$quantite;
            $quantite_plastique=$quantite;
        }else if($poubelle->type==="papier"){
            $camion->volume_actuelle_papier+=$quantite;
            $quantite_papier=$quantite;
        }else if($poubelle->type==="composte"){
            $camion->volume_actuelle_composte+=$quantite;
            $quantite_composte=$quantite;
        }else if($poubelle->type==="canette"){
            $camion->volume_actuelle_canette+=$quantite;
            $quantite_canette=$quantite;
        }
        Vider_poubelle::create([
            'poubelle_id'=>$poubelle_id,
            'camion_id'=>$camion_id,
            'date_depot'=>now(),
            'quantite_depose_plastique'=>$quantite_plastique,
            'quantite_depose_papier'=>$quantite_papier,
            'quantite_depose_composte'=>$quantite_composte,
            'quantite_depose_canette'=>$quantite_canette,
            'type_poubelle'=>$poubelle->type,
            'etat'=>$poubelle->Etat,
        ]);
        $poubelle->Etat=0;
        $poubelle->save();
        $camion->save();
        $myArray = [
            'poubelle_id'=>$poubelle->id,
            'type'=>$poubelle->type,
            'camion_id'=>$camion->id,
            'ouvrier_id'=>$ouvrier->id,
            'quantite'=>$quantite,
            'quantite_plastique_camion'=>$camion->volume_actuelle_plastique,
            'quantite_papier_camion'=>$camion->volume_actuelle_papier,
            'quantite_composte_camion'=>$camion->volume_actuelle_composte,
            'quantite_canette_camion'=>$camion->volume_actuelle_canette,
        ];
        return response()->json($myArray);
    }
}
