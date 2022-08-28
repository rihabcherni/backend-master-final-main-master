<?php
namespace App\Http\Controllers\Globale;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Controllers\ResponsableEtablissement\CrudResponsable\PoubelleController;
use App\Http\Controllers\ResponsableEtablissement\DashboardResponsableEtablissement\GlobaleStatistiqueController;
use App\Models\Planning;
use App\Models\Etablissement;
use App\Models\Reparation_poubelle;
use App\Models\Reparation_camion;
use Carbon\Carbon;

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
            return [16,19];
        }
    }

    public function gererTemps($indicejour, $week){
        if(6<=$indicejour){
            return $indicejour-6;
        }else return  $indicejour;
    }

    function max6_75($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max >= 75){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }else{
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max6_25_75($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max >25 && $max<= 75 ){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[2] ,
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+3, $week)],
                    'start'=>$horaire[2] ,
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);

            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
            }else{
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max6_25($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max <= 25 ){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+2],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+4, $week)],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+2],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+4, $week)],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max12_75($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max >= 75){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[0] ,
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[0] ,
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }else{
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max12_25_75 ($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max >25 && $max<= 75 ){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+3, $week)],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg> 25 && $avg< 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[4],
                    'end'=>$horaire[35],
                    'type_poubelle'=>$type,
                ]);
            }else{
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max12_25($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max <= 25 ){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+3],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+4, $week)],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+2],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+4, $week)],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
            }
        }

    }

    function max15_75($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max >= 75){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[2] ,
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
            }else{
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+1, $week)],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max15_25_75 ($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max >25 && $max<= 75 ){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+2],
                    'start'=>$horaire[0] ,
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+4, $week)],
                    'start'=>$horaire[2] ,
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+3, $week)],
                    'start'=>$horaire[4],
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }else{
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+1],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+2, $week)],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    function max15_25($max, $avg, $type, $etab, $week, $horaire, $j){
        if($max <= 25 ){
            if($avg <= 25){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+3],
                    'start'=>$horaire[2] ,
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+5, $week)],
                    'start'=>$horaire[4] ,
                    'end'=>$horaire[5],
                    'type_poubelle'=>$type,
                ]);
            }elseif($avg > 25 && $avg < 75){
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[$j+3],
                    'start'=>$horaire[0],
                    'end'=>$horaire[1],
                    'type_poubelle'=>$type,
                ]);
                Planning::create([
                    'etablissement_id'=> $etab,
                    'jour' =>$week[self::gererTemps($j+5, $week)],
                    'start'=>$horaire[2],
                    'end'=>$horaire[3],
                    'type_poubelle'=>$type,
                ]);
            }
        }
    }

    public function planningResponsable(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::find($etab_id)->first()->id;
        $allPlanning =Planning::all();
        $dashboard_etablissement_controller = new GlobaleStatistiqueController;
        $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->globaleStatistiques();

        $poubelle_controller = new PoubelleController;
        $data_poubelle_controller = $poubelle_controller->index()->getData();
        $poubelles = $data_poubelle_controller->data;

        $week=['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        $jour = strtolower(Carbon::now()->translatedFormat('l'));
        $heure_systeme = Carbon::now()->translatedFormat('H');

        $horaire= [6,12,13,15,16,19];
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

        $arr_plastique=[];   $arr_papier=[];   $arr_composte=[];   $arr_canette=[];

        $score_plastique_25=[];  $score_plastique_50=[];  $score_plastique_75=[];
        $score_papier_25=[];     $score_papier_50=[];     $score_papier_75=[];
        $score_composte_25=[];   $score_composte_50=[];   $score_composte_75=[];
        $score_canette_25=[];    $score_canette_50=[];    $score_canette_75=[];

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
                }elseif($poubelle->Etat <75){
                    array_push($score_composte_50,$poubelle);
                }else{
                    array_push($score_composte_75,$poubelle);
                }
            }
            if($poubelle->type=='canette'){
                array_push($arr_canette,$poubelle);
                if($poubelle->Etat <=25){
                    array_push($score_canette_25,$poubelle);
                }elseif($poubelle->Etat <75){
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

        if( empty($allPlanning->toArray())){
            if ($heure_systeme <= 12){
                $j = 0;
                if(count($week)<$i){
                    $j=$i-count($week);
                }else $j = array_search($jour, $week);
                /**     si  max >= 75         */
                self::max6_75($max_plastique, $avg_plastique, 'plastique', $etablissement, $week, $horaire, $j);
                self::max6_75($max_papier, $avg_papier, 'papier', $etablissement, $week, $horaire, $j);
                self::max6_75($max_composte, $avg_composte, 'composte' ,$etablissement, $week, $horaire, $j);
                self::max6_75($max_canette, $avg_canette, 'canette', $etablissement, $week, $horaire, $j);

                /**             25 < max < 75              */
                self::max6_25_75($max_plastique, $avg_plastique,'plastique', $etablissement, $week, $horaire, $j);
                self::max6_25_75($max_papier, $avg_papier,'papier', $etablissement, $week, $horaire, $j);
                self::max6_25_75($max_composte, $avg_composte,'composte', $etablissement, $week, $horaire, $j);
                self::max6_25_75($max_canette, $avg_canette,'canette', $etablissement, $week, $horaire, $j);

                /**               max >= 25              */
                self::max6_25($max_plastique, $avg_plastique,'plastique', $etablissement, $week, $horaire, $j);
                self::max6_25($max_papier, $avg_papier,'papier', $etablissement, $week, $horaire, $j);
                self::max6_25($max_composte, $avg_composte,'composte', $etablissement, $week, $horaire, $j);
                self::max6_25($max_canette, $avg_canette,'canette', $etablissement, $week, $horaire, $j);

            }elseif($heure_systeme > 12 && $heure_systeme <= 15 ){
                $j = 0;
                if(count($week)<$i){
                    $j=$i-count($week);
                }else $j = array_search($jour, $week);
                /**     si  max >= 75         */

                self::max12_75($max_plastique, $avg_plastique, 'plastique', $etablissement, $week, $horaire, $j);
                self::max12_75($max_papier, $avg_papier, 'papier', $etablissement, $week, $horaire, $j);
                self::max12_75($max_composte, $avg_composte, 'composte' ,$etablissement, $week, $horaire, $j);
                self::max12_75($max_canette, $avg_canette, 'canette', $etablissement, $week, $horaire, $j);
                /**             25 < max < 75              */

                self::max12_25_75($max_plastique, $avg_plastique,'plastique', $etablissement, $week, $horaire, $j);
                self::max12_25_75($max_papier, $avg_papier,'papier', $etablissement, $week, $horaire, $j);
                self::max12_25_75($max_composte, $avg_composte,'composte', $etablissement, $week, $horaire, $j);
                self::max12_25_75($max_canette, $avg_canette,'canette', $etablissement, $week, $horaire, $j);
                /**               max >= 25              */

                self::max12_25($max_plastique, $avg_plastique,'plastique', $etablissement, $week, $horaire, $j);
                self::max12_25($max_papier, $avg_papier,'papier', $etablissement, $week, $horaire, $j);
                self::max12_25($max_composte, $avg_composte,'composte', $etablissement, $week, $horaire, $j);
                self::max12_25($max_canette, $avg_canette,'canette', $etablissement, $week, $horaire, $j);

            }elseif($heure_systeme > 15 && $heure_systeme <= 19 ){
                $j = 0;
                if(count($week)<$i){
                    $j=$i-count($week);
                }else $j = array_search($jour, $week);
                /**     si  max >= 75         */

                self::max15_75($max_plastique, $avg_plastique, 'plastique', $etablissement, $week, $horaire, $j);
                self::max15_75($max_papier, $avg_papier, 'papier', $etablissement, $week, $horaire, $j);
                self::max15_75($max_composte, $avg_composte, 'composte' ,$etablissement, $week, $horaire, $j);
                self::max15_75($max_canette, $avg_canette, 'canette', $etablissement, $week, $horaire, $j);
                /**             25 < max < 75              */

                self::max15_25_75($max_plastique, $avg_plastique,'plastique', $etablissement, $week, $horaire, $j);
                self::max15_25_75($max_papier, $avg_papier,'papier', $etablissement, $week, $horaire, $j);
                self::max15_25_75($max_composte, $avg_composte,'composte', $etablissement, $week, $horaire, $j);
                self::max15_25_75($max_canette, $avg_canette,'canette', $etablissement, $week, $horaire, $j);
                /**               max >= 25              */

                self::max15_25($max_plastique, $avg_plastique,'plastique', $etablissement, $week, $horaire, $j);
                self::max15_25($max_papier, $avg_papier,'papier', $etablissement, $week, $horaire, $j);
                self::max15_25($max_composte, $avg_composte,'composte', $etablissement, $week, $horaire, $j);
                self::max15_25($max_canette, $avg_canette,'canette', $etablissement, $week, $horaire, $j);
            }
        } elseif($heure_systeme == 23){
            DB::table('plannings')->truncate();
        }

        self::etatProblem();

        $lundi = DB::table('plannings')
            ->select('start','end','type_poubelle','validation','statut')
            ->where('jour','lundi')
            ->get();
        $mardi = DB::table('plannings')
            ->select('start','end','type_poubelle','validation','statut')
            ->where('jour','mardi')
            ->get();
        $mercredi = DB::table('plannings')
            ->select('start','end','type_poubelle','validation','statut')
            ->where('jour','mercredi')
            ->get();
        $jeudi = DB::table('plannings')
            ->select('start','end','type_poubelle','validation','statut')
            ->where('jour','jeudi')
            ->get();
        $vendredi = DB::table('plannings')
            ->select('start','end','type_poubelle','validation','statut')
            ->where('jour','vendredi')
            ->get();
        $samedi = DB::table('plannings')
            ->select('start','end','type_poubelle','validation','statut')
            ->where('jour','samedi')
            ->get();

        $affichage=[
            ["Lundi",$lundi],
            ["Mardi",$mardi],
            ["Mercredi",$mercredi],
            ["Jeudi",$jeudi],
            ["Vendredi",$vendredi],
            ["Samedi",$samedi],
            // ['max_plastique',$max_plastique],
            // ['moy_plastique',$avg_plastique],
            // ['max_papier',$max_papier],
            // ['moy_papier',$avg_papier],
            // ['max_composte',$max_composte],
            // ['moy_composte',$avg_composte],
            // ['max_canette',$max_canette],
            // ['moy_canette',$avg_canette],
        ];

        return response()->json($affichage);
    }

    public function checkEtat ($table, $type){
        $j=0;
        for ($i = 0; $i < count($table) ; $i++) {
            if ($table[$i]->etat == 0) {
                $j++;
            }
        }
        if ($j == count($table) ) {
            Planning::all()->where('type_poubelle',$type)->first()->update(['statut' => 'collected']);
        }
        return true;
    }

    public function etatCollected(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::find($etab_id)->with('poubelles')->first()->poubelles;
        $allPlanning =Planning::all();
        $allplastique = DB::table('poubelles')
            ->select('type', 'etat')
            ->where('type','plastique')
            ->get();
        $allpapier = DB::table('poubelles')
            ->select('type', 'etat')
            ->where('type','papier')
            ->get();
        $allcomposte = DB::table('poubelles')
            ->select('type', 'etat')
            ->where('type','composte')
            ->get();
        $allcanette = DB::table('poubelles')
            ->select('type', 'etat')
            ->where('type','canette')
            ->get();
        self::checkEtat($allplastique,'plastique');
        self::checkEtat($allpapier,'papier');
        self::checkEtat($allcomposte,'composte');
        self::checkEtat($allcanette,'canette');

        return $allPlanning;
    }

    public function listePannesPoubelles(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $poubellesEtab= Etablissement::find($etab_id)->with('poubelles')->first()->poubelles;
        // $rep_camion= Etablissement::find($etab_id)->with('reparation_camions')->first();

        $idtypepoubelles= [];
        foreach($poubellesEtab as $poub){
            array_push($idtypepoubelles,[$poub->id,$poub->type]);
        }

        $pannespoubEtab=[];
        foreach($idtypepoubelles as $ppoub){
            $poubellePanneetab=Reparation_poubelle::where("poubelle_id", $ppoub[0])->first();
            if($poubellePanneetab !== null){
                array_push($pannespoubEtab,$poubellePanneetab);
            }
        }
        $listePannesPoubelle =[];
        foreach($idtypepoubelles as $poubelle){
            foreach($pannespoubEtab as $panne){
                if ($poubelle[0] == $panne->poubelle_id ) {
                    array_push($listePannesPoubelle, $poubelle);
                }
            }

        }

        return response()->json($listePannesPoubelle);
    }

    public function listePannesCamions(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $camion_id= Etablissement::find($etab_id)->first()->camion_id;
        // $camion= Camion::find($camion_id)->first();
        $panneCamion=Reparation_camion::where("camion_id", $camion_id)->first();

        return response()->json($panneCamion);
    }

    public function etatProblem(){
        $pannePoubelle= self::listePannesPoubelles()->original;
        $panneCamion= self::listePannesCamions()->original;

        if( $pannePoubelle !== null ){
            foreach ($pannePoubelle as $panne) {
                Planning::all()->where('type_poubelle',$panne[1])->first()->update(['statut' => 'problem']);
            }
        }
        if ( $panneCamion !== null  ) {
            Planning::all()->where('type_poubelle','plastique')->first()->update(['statut' => 'problem']);
            Planning::all()->where('type_poubelle','papier')->first()->update(['statut' => 'problem']);
            Planning::all()->where('type_poubelle','composte')->first()->update(['statut' => 'problem']);
            Planning::all()->where('type_poubelle','canette')->first()->update(['statut' => 'problem']);

        }

        return [['Pannes Poubelles',$pannePoubelle],[ 'Pannes Camions',$panneCamion]];

    }

}
