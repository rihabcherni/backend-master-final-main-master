<?php
namespace App\Http\Controllers\Globale;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable\PoubelleController;
use App\Http\Controllers\API\Dashboard\DashboardResponsableEtablissement\GlobaleStatistiqueController;
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
            return [16,19];
        }
    }

    public function gererTemps($indicejour, $week){
        if(6<=$indicejour){
            return $indicejour-6;
        }else return  $indicejour;      
    }

    public function planningResponsable(){
        $allPlanning =Planning::all();
        $GlobaleStatistiqueController = new GlobaleStatistiqueController;
        $data_dashboard_etablissement_controller = $GlobaleStatistiqueController->globaleStatistiques();

        $poubelle_controller = new PoubelleController;
        $data_poubelle_controller = $poubelle_controller->index()->getData();
        $poubelles = $data_poubelle_controller->data;

        $week=['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        $jour= strtolower(Carbon::now()->translatedFormat('l'));
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
                    if($max_plastique >= 75){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier >= 75){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte >= 75){
                        if($avg_composte <= 25){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
        
                    if($max_canette >= 75){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
                    /**             25 < max < 75              */
                    if($max_plastique >25 && $max_plastique<= 75 ){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier > 25 && $max_papier < 75 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]); 
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte > 25 && $max_composte < 75 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
        
                    if($max_canette > 25 && $max_canette < 75 ){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
                    /**               max >= 25              */
                    if($max_plastique <= 25 ){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier <= 25 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte <= 25 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
        
                    if($max_canette <= 25 ){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
        
                
            }elseif($heure_systeme > 12 && $heure_systeme <= 15 ){
                    $j = 0;
                    if(count($week)<$i){
                        $j=$i-count($week);
                    }else $j = array_search($jour, $week);
                    /**     si  max >= 75         */

                    if($max_plastique >= 75){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier >= 75){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte >= 75){
                        if($avg_composte <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
        
                    if($max_canette >= 75){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
                    /**             25 < max < 75              */
                    
                    if($max_plastique >25 && $max_plastique<= 75 ){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[35],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier > 25 && $max_papier < 75 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte > 25 && $max_composte < 75 ){
                        if($avg_composte <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
                    
                    if($max_canette > 25 && $max_canette < 75 ){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
                    /**               max >= 25              */
                
                    if($max_plastique <= 25 ){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier <= 25 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte <= 25 ){
                        if($avg_composte <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
        
                    if($max_canette <= 25 ){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
        

            }elseif($heure_systeme > 15 && $heure_systeme <= 19 ){
                    $j = 0;
                    if(count($week)<$i){
                        $j=$i-count($week);
                    }else $j = array_search($jour, $week);
                    /**     si  max >= 75         */
                    if($max_plastique >= 75){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4] ,
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier >= 75){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'papier',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'papier',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'papier',
                            ]);
                        }
                    }
        
                    if($max_composte >= 75){
                        if($avg_composte <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'composte',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'composte',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+1, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'composte',
                            ]);
                        }
                    }
        
                    if($max_canette >= 75){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'canette',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'canette',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'canette',
                            ]);
                        }
                    }
                    /**             25 < max < 75              */
                    if($max_plastique >25 && $max_plastique<= 75 ){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+4, $week)],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+3, $week)],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                            Planning::create([
                                'jour' =>$week[self::gererTemps($j+2, $week)],
                                'start'=>$horaire[2],
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier > 25 && $max_papier < 75 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_composte > 25 && $max_composte < 75 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_canette > 25 && $max_canette < 75 ){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+2],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[4],
                                'end'=>$horaire[5],
                                'type_poubelle'=>'plastique',
                            ]);
                        }else{
                            Planning::create([
                                'jour' =>$week[$j+1],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
                    /**               max >= 25              */
                    if($max_plastique <= 25 ){
                        if($avg_plastique <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[2] ,
                                'end'=>$horaire[3],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_plastique > 25 && $avg_plastique < 75){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_papier <= 25 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_papier > 25 && $avg_papier < 75){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_composte <= 25 ){
                        if($avg_papier <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_composte > 25 && $avg_composte < 75){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
                    if($max_canette <= 25 ){
                        if($avg_canette <= 25){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0] ,
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
        
                        }elseif($avg_canette > 25 && $avg_canette < 75){
                            Planning::create([
                                'jour' =>$week[$j+3],
                                'start'=>$horaire[0],
                                'end'=>$horaire[1],
                                'type_poubelle'=>'plastique',
                            ]);
                        }
                    }
        
    
            }
        } elseif($heure_systeme > 19){
            DB::table('plannings')->truncate();
        }  

        $planninglist = Planning::all();
        // $planning_sorted = Planning::where('jour',"mardi")->get();

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


    public function confirmePlanningOuvrier(){
        return 'rrr';  
    }
}
