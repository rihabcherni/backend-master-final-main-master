<?php

namespace App\Http\Controllers\ResponsableEtablissement\DashboardResponsableEtablissement;
use App\Http\Controllers\Globale\Controller;
use App\Models\Etablissement;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etage_etablissement;
class TablePoubellePlusRemplisController extends Controller{
    public function PoubellePlusRemplis(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;

        $etablissement= Etablissement::with('poubelles')->find($etab_id)->get();
        $topPoubelle= collect($etablissement[0]->poubelles)->sortByDesc('Etat')->values()->take(5);
        $p=[];
        foreach ($topPoubelle as $poubelle){
            $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id )->first();
            $etage= Etage_etablissement::where('id',$bloc_poubelle["etage_etablissement_id"] )->first();
            $bloc_etablissement= Bloc_etablissement::where('id',$etage["bloc_etablissement_id"])->first();
            array_push($p ,['id'=>$poubelle['id'],'etat'=>$poubelle['Etat'],'nom'=>$poubelle['nom'],
            'type'=>$poubelle['type'],
            'bloc_poubelle'=>$bloc_poubelle["id"],'etage'=>$etage["nom_etage_etablissement"],
            'bloc_etablissement'=>$bloc_etablissement["nom_bloc_etablissement"]]);
        }
        return  $p;
    }
}


