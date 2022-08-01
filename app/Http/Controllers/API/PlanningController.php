<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable\PoubelleController;
use App\Http\Controllers\API\Dashboard\DashboardEtablissementController;
use App\Models\Planning;
use Carbon\Carbon;
use App\Http\Resources\GestionPoubelleEtablissements\Planning as Ressource_Planning;

class PlanningController extends BaseController{
    function cmp($a, $b) {
        if ($a->Etat == $b->Etat) {
            return 0;
        }
        return ($a->Etat < $b->Etat) ? 1 : -1;
    }
    function temps($h){
        if($h <= 11){
            return [6,12];
        }elseif($h <=14){
            return [13,15];
        }else{
            return [16,18];
        }
    }
    public function planningResponsable(){
        $allPlanning =Planning::all();
        $dashboard_etablissement_controller = new DashboardEtablissementController;
        $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->dashboard_etablissement();

        $poubelle_controller = new PoubelleController;
        $data_poubelle_controller = $poubelle_controller->index()->getData();
        $poubelles = $data_poubelle_controller->data;

        $week=['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        $jour = strtolower(Carbon::now()->translatedFormat('l'));
        $heure_systeme = Carbon::now()->translatedFormat('H');

        $temps = $this->temps($heure_systeme);
        $start = $temps[0];
        $end = $temps[1];

        $max_plastique = $data_dashboard_etablissement_controller[1]['max_qt_poubelle_plastique'];
        $avg_plastique = $data_dashboard_etablissement_controller[1]['pourcentage_qt_poubelle_plastique'];

        $max_papier = $data_dashboard_etablissement_controller[1]['max_qt_poubelle_papier'];
        $avg_papier = $data_dashboard_etablissement_controller[1]['pourcentage_qt_poubelle_papier'];

        $max_composte = $data_dashboard_etablissement_controller[1]['max_qt_poubelle_composte'];
        $avg_composte = $data_dashboard_etablissement_controller[1]['pourcentage_qt_poubelle_composte'];

        $max_canette = $data_dashboard_etablissement_controller[1]['max_qt_poubelle_canette'];
        $avg_canette = $data_dashboard_etablissement_controller[1]['pourcentage_qt_poubelle_canette'];

        $arr_plastique=[];
        $arr_papier=[];
        $arr_composte=[];
        $arr_canette=[];

        $score_plastique_25=[];
        $score_plastique_50=[];
        $score_plastique_75=[];
        $score_papier_25=[];
        $score_papier_50=[];
        $score_papier_75=[];
        $score_composte_25=[];
        $score_composte_50=[];
        $score_composte_75=[];
        $score_canette_25=[];
        $score_canette_50=[];
        $score_canette_75=[];

        foreach($poubelles as $poubelle){
            if($poubelle->type=='plastique'){
                array_push($arr_plastique,$poubelle);
                if($poubelle->Etat <=25){
                    array_push($score_plastique_25,$poubelle);
                }elseif($poubelle->Etat<75){
                    array_push($score_plastique_50,$poubelle);
                }else{
                    array_push($score_plastique_75,$poubelle);
                }
            }
            if($poubelle->type=='papier'){
                array_push($arr_papier,$poubelle);
                if($poubelle->Etat <=25){
                    array_push($score_papier_25,$poubelle);
                }elseif($poubelle->Etat<75){
                    array_push($score_papier_50,$poubelle);
                }else{
                    array_push($score_papier_75,$poubelle);
                }
            }
            if($poubelle->type=='composte'){
                array_push($arr_composte,$poubelle);
                if($poubelle->Etat <=25){
                    array_push($score_composte_25,$poubelle);
                }elseif($poubelle->Etat<75){
                    array_push($score_composte_50,$poubelle);
                }else{
                    array_push($score_composte_75,$poubelle);
                }
            }
            if($poubelle->type=='canette'){
                array_push($arr_canette,$poubelle);
                if($poubelle->Etat <=25){
                    array_push($score_canette_25,$poubelle);
                }elseif($poubelle->Etat<75){
                    array_push($score_canette_50,$poubelle);
                }else{
                    array_push($score_canette_75,$poubelle);
                }
            }
        }

        usort($arr_plastique, [PlanningController::class, "cmp"]);
        usort($arr_papier, [PlanningController::class, "cmp"]);
        usort($arr_composte, [PlanningController::class, "cmp"]);
        usort($arr_canette, [PlanningController::class, "cmp"]);

        usort($score_plastique_25, [PlanningController::class, "cmp"]);
        usort($score_plastique_50, [PlanningController::class, "cmp"]);
        usort($score_plastique_75, [PlanningController::class, "cmp"]);

        usort($score_papier_25, [PlanningController::class, "cmp"]);
        usort($score_papier_50, [PlanningController::class, "cmp"]);
        usort($score_papier_75, [PlanningController::class, "cmp"]);

        usort($score_composte_25, [PlanningController::class, "cmp"]);
        usort($score_composte_50, [PlanningController::class, "cmp"]);
        usort($score_composte_75, [PlanningController::class, "cmp"]);

        usort($score_canette_25, [PlanningController::class, "cmp"]);
        usort($score_canette_50, [PlanningController::class, "cmp"]);
        usort($score_canette_75, [PlanningController::class, "cmp"]);

        $i=0;
        foreach($week as $day){
            if(strcmp($day, $jour)==0){
                break;
            }
            $i=$i+1;
        }

        if(count($allPlanning)==0){

            /**               max >= 75              */
            if($max_plastique >= 75){
                if($avg_plastique <= 25){
                    $j=0;
                    $i = $i+1;
                    if(count($week)<$i){
                        $j=$i-count($week);
                    }
                    foreach($score_plastique_75 as $plas){
                        Planning::create([
                            'jour' =>$week[$j],
                            'start'=>$start,
                            'end'=>$end,
                            'type_poubelle'=>$plas->type,
                            'id_poubelle'=>$plas->id,
                        ]);
                    }

                }elseif($arr_plastique <= 50){
                    foreach($score_plastique_75 as $plas){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,
                            'type_poubelle'=>$plas->type,
                            'id_poubelle'=>$plas->id,
                        ]);
                    }
                }else{
                    foreach($score_plastique_75 as $plas){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,
                            'type_poubelle'=>$plas->type,
                            'id_poubelle'=>$plas->id,
                        ]);
                    }
                }
            }else{
                $j=0;
                $i = $i+2;
                if(count($week)<$i){
                    $j=$i-count($week);
                }
                foreach($score_plastique_75 as $plas){
                    Planning::create([
                        'jour' =>$week[$j],
                        'start'=>$start,
                        'end'=>$end,
                        'type_poubelle'=>$plas->type,
                        'id_poubelle'=>$plas->id,
                    ]);
                }
            }

            if($max_papier >= 75){
                if($avg_papier <= 25){
                    $j=0;
                    $i = $i+1;
                    if(count($week)<$i){
                        $j=$i-count($week);
                    }
                    foreach($score_papier_75 as $pap){
                        Planning::create([
                            'jour' =>$week[$j],
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$pap->type,
                            'id_poubelle'=>$pap->id,
                        ]);
                    }
                }elseif($avg_papier <= 50){
                    foreach($score_papier_75 as $pap){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$pap->type,
                            'id_poubelle'=>$pap->id,
                        ]);
                    }
                }else{
                    foreach($score_papier_75 as $pap){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$pap->type,
                            'id_poubelle'=>$pap->id,
                        ]);
                    }
                }
            }else{
                $j=0;
                $i = $i+2;
                if(count($week)<$i){
                    $j=$i-count($week);
                }
                foreach($score_papier_75 as $pap){
                    Planning::create([
                        'jour' =>$week[$j],
                        'start'=>$start,
                        'end'=>$end,

                        'type_poubelle'=>$pap->type,
                        'id_poubelle'=>$pap->id,
                    ]);
                }
            }

            if($max_composte >= 75){
                if($avg_composte <= 25){
                    $j=0;
                    $i = $i+1;
                    if(count($week)<$i){
                        $j=$i-count($week);
                    }
                    foreach($score_composte_75 as $comp){
                        Planning::create([
                            'jour' =>$week[$j],
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$comp->type,
                            'id_poubelle'=>$comp->id,
                        ]);
                    }
                }elseif($avg_composte <= 50){
                    foreach($score_composte_75 as $comp){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$comp->type,
                            'id_poubelle'=>$comp->id,
                        ]);
                    }
                }else{
                    foreach($score_composte_75 as $comp){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$comp->type,
                            'id_poubelle'=>$comp->id,
                        ]);
                    }
                }
            }else{
                $j=0;
                $i = $i+2;
                if(count($week)<$i){
                    $j=$i-count($week);
                }
                foreach($score_composte_75 as $comp){
                    Planning::create([
                        'jour' =>$week[$j],
                        'start'=>$start,
                        'end'=>$end,

                        'type_poubelle'=>$comp->type,
                        'id_poubelle'=>$comp->id,
                    ]);
                }
            }

            if($max_canette >= 75){
                if($avg_canette <= 25){
                    $j=0;
                    $i = $i+1;
                    if(count($week)<$i){
                        $j=$i-count($week);
                    }
                    foreach($score_canette_75 as $cant){
                        Planning::create([
                            'jour' =>$week[$j],
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$cant->type,
                            'id_poubelle'=>$cant->id,
                        ]);
                    }
                }elseif($avg_canette <= 50){
                    foreach($score_canette_75 as $cant){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$cant->type,
                            'id_poubelle'=>$cant->id,
                        ]);
                    }
                }else{
                    foreach($score_canette_75 as $cant){
                        Planning::create([
                            'jour' =>$jour,
                            'start'=>$start,
                            'end'=>$end,

                            'type_poubelle'=>$cant->type,
                            'id_poubelle'=>$cant->id,
                        ]);
                    }
                }
            }else{
                $j=0;
                $i = $i+2;
                if(count($week)<$i){
                    $j=$i-count($week);
                }
                foreach($score_canette_75 as $cant){
                    Planning::create([
                        'jour' =>$week[$j],
                        'start'=>$start,
                        'end'=>$end,

                        'type_poubelle'=>$cant->type,
                        'id_poubelle'=>$cant->id,
                    ]);
                }
            }
                        /**               max >= 50              */
                        /**               max >= 25              */

        }else{
            foreach($allPlanning as $planning){
                if(strcmp($planning->type_poubelle ,"plastique") ==0){
                    if($max_plastique >= 75){
                        if($avg_plastique <= 25){
                            $j=0;
                            $i = $i+1;
                            if(count($week)<$i){
                                $j=$i-count($week);
                            }
                            foreach($score_plastique_75 as $plas){
                                if($plas->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$week[$j],
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$plas->type,
                                        'id_poubelle'=>$plas->id,
                                    ]);
                                }
                            }

                        }elseif($arr_plastique <= 50){
                            foreach($score_plastique_75 as $plas){
                                if($plas->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$plas->type,
                                        'id_poubelle'=>$plas->id,
                                    ]);
                                    break;
                                }
                            }
                        }else{
                            foreach($score_plastique_75 as $plas){
                                if($plas->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$plas->type,
                                        'id_poubelle'=>$plas->id,
                                    ]);
                                    break;
                                }
                            }
                        }
                    }else{
                        $j=0;
                        $i = $i+2;
                        if(count($week)<$i){
                            $j=$i-count($week);
                        }
                        foreach($score_plastique_75 as $plas){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$start,
                                'end'=>$end,

                                'type_poubelle'=>$plas->type,
                                'id_poubelle'=>$plas->id,
                            ]);
                        }
                    }
                }

                if(strcmp($planning->type_poubelle ,"papier") ==0){
                    if($max_papier >= 75){
                        if($avg_papier <= 25){
                            $j=0;
                            $i = $i+1;
                            if(count($week)<$i){
                                $j=$i-count($week);
                            }
                            foreach($score_papier_75 as $pap){
                                if($pap->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$week[$j],
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$pap->type,
                                        'id_poubelle'=>$pap->id,
                                    ]);
                                }
                            }
                        }elseif($avg_papier <= 50){
                            foreach($score_papier_75 as $pap){
                                if($pap->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$pap->type,
                                    'id_poubelle'=>$pap->id,
                                    ]);
                                }
                            }
                        }else{
                            foreach($score_papier_75 as $pap){
                                if($pap->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$pap->type,
                                    'id_poubelle'=>$pap->id,
                                    ]);
                                }
                            }
                        }
                    }else{
                        $j=0;
                        $i = $i+2;
                        if(count($week)<$i){
                            $j=$i-count($week);
                        }
                        foreach($score_papier_75 as $pap){
                            if($pap->id == $planning->id_poubelle){
                                Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                    'jour' =>$week[$j],
                                    'start'=>$start,
                                    'end'=>$end,

                                    'type_poubelle'=>$pap->type,
                                    'id_poubelle'=>$pap->id,
                                ]);
                            }
                        }
                    }
                }

                if(strcmp($planning->type_poubelle ,"composte") ==0){
                    if($max_composte >= 75){
                        if($avg_composte <= 25){
                            $j=0;
                            $i = $i+1;
                            if(count($week)<$i){
                                $j=$i-count($week);
                            }
                            foreach($score_composte_75 as $comp){
                                if($comp->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$week[$j],
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$comp->type,
                                        'id_poubelle'=>$comp->id,
                                    ]);
                                }
                            }
                        }elseif($avg_composte <= 50){
                            foreach($score_composte_75 as $comp){
                                if($comp->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$comp->type,
                                        'id_poubelle'=>$comp->id,
                                    ]);
                                }
                            }
                        }else{
                            foreach($score_composte_75 as $comp){
                                if($comp->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$comp->type,
                                        'id_poubelle'=>$comp->id,
                                    ]);
                                }
                            }
                        }
                    }else{
                        $j=0;
                        $i = $i+2;
                        if(count($week)<$i){
                            $j=$i-count($week);
                        }
                        foreach($score_composte_75 as $comp){
                            if($comp->id == $planning->id_poubelle){
                                Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                    'jour' =>$week[$j],
                                    'start'=>$start,
                                    'end'=>$end,

                                    'type_poubelle'=>$comp->type,
                                    'id_poubelle'=>$comp->id,
                                ]);
                            }
                        }
                    }
                }

                if(strcmp($planning->type_poubelle ,"canette") ==0){
                    if($max_canette >= 75){
                        if($avg_canette <= 25){
                            $j=0;
                            $i = $i+1;
                            if(count($week)<$i){
                                $j=$i-count($week);
                            }
                            foreach($score_canette_75 as $cant){
                                if($cant->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$week[$j],
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$cant->type,
                                        'id_poubelle'=>$cant->id,
                                    ]);
                                }
                            }
                        }elseif($avg_canette <= 50){
                            foreach($score_canette_75 as $cant){
                                if($cant->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$cant->type,
                                        'id_poubelle'=>$cant->id,
                                    ]);
                                }
                            }
                        }else{
                            foreach($score_canette_75 as $cant){
                                if($cant->id == $planning->id_poubelle){
                                    Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                        'jour' =>$jour,
                                        'start'=>$start,
                                        'end'=>$end,

                                        'type_poubelle'=>$cant->type,
                                        'id_poubelle'=>$cant->id,
                                    ]);
                                }
                            }
                        }
                    }else{
                        $j=0;
                        $i = $i+2;
                        if(count($week)<$i){
                            $j=$i-count($week);
                        }
                        foreach($score_canette_75 as $cant){
                            if($cant->id == $planning->id_poubelle){
                                Planning::where('id_poubelle', $planning->id_poubelle)->update([
                                    'jour' =>$week[$j],
                                    'start'=>$start,
                                    'end'=>$end,

                                    'type_poubelle'=>$cant->type,
                                    'id_poubelle'=>$cant->id,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return $this->handleResponse(Ressource_Planning::collection($allPlanning) ,'Tous les planning!');
    }
}
