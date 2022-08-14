<?php

namespace App\Http\Controllers\ResponsableEtablissement\DashboardResponsableEtablissement;
use App\Http\Controllers\Globale\Controller;
use App\Models\Etablissement;
use App\Models\Poubelle;
use App\Models\Reparation_poubelle;
use Carbon\Carbon;

class PannePoubelleController extends Controller{
    public function panneetablissementPoubelle(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::find($etab_id);
        $poubelleEtab=$etablissement->poubelles;
        $poubelle=[];
        foreach($poubelleEtab as $p){
            array_push($poubelle,$p->id);
        }
        $poubelleEtb=[];

        foreach($poubelle as $pp){
            $poubellePanneetab=Reparation_poubelle::where("poubelle_id", $pp)->first();
            if($poubellePanneetab !== null){
                array_push($poubelleEtb,$poubellePanneetab);
            }
        }
        return $poubelleEtb;
    }

    public function dashboardPanneetablissementPoubelle(){
        $dashboard_etablissement_controller = new PannePoubelleController;
        $data = $dashboard_etablissement_controller->panneetablissementPoubelle();
        $t= [];
        foreach($data as $d){
            array_push($t,$d);
        }
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::where('id',$etab_id)->  withcount('poubelles')->get();

        $nbr_poubelle_etab=$etablissement[0]->poubelles_count;
        $nbr_poubelle_Total=Poubelle::count();
        if($nbr_poubelle_etab!=0){ $pourcentage_panne_poubelle_etab=count($t)/$nbr_poubelle_etab; }
        else {  $pourcentage_panne_poubelle_etab=0; }

        if($nbr_poubelle_Total!=0){
            $pourcentage_panne_poubelle_totale=count($t)/$nbr_poubelle_Total;
        }else {
            $pourcentage_panne_poubelle_totale=0;
        }
        $cout=[];
        foreach($t as $a){
            array_push ($cout, $a->cout );
        }

        $duree=[];
        foreach($t as $d){
            array_push ($duree,  Carbon::parse($a->date_fin_reparation)->diffInDays( Carbon::parse($a->date_debut_reparation)) );
        }
        return [
            'nombre_panne'=>count($cout),
            'cout_totale_panne'=>array_sum($cout),
            'cout_moyenne_panne'=>array_sum($cout)/count($cout),
            'cout_min_panne'=>min($cout),
            'cout_max_panne'=>max($cout),

            'duree_totale_panne'=>array_sum($duree),
            'duree_moyenne_panne'=>array_sum($duree)/count($duree),
            'duree_min_panne'=>min($duree),
            'duree_max_panne'=>max($duree),

            'pourcentage_panne_par_rapport_poubelles_etablissement'=>$pourcentage_panne_poubelle_etab,
            'pourcentage_panne_par_rapport_totat_poubelle'=>$pourcentage_panne_poubelle_totale,
        ];

    }


}

