<?php
namespace App\Http\Controllers\Ouvrier;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Models\Planning;
class PlanningOuvrierController extends BaseController{
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

    public function planningOuvrier(){
        $ouvrier_id=auth()->guard('ouvrier')->user()->id;
        $camion_id= auth()->guard('ouvrier')->user()->camion_id;

        $etabs = DB::table('etablissements')
            ->select('id','camion_id','nom_etablissement','adresse')
            ->where('camion_id',$camion_id)
            ->get();
        $planninglist = Planning::all();

        $planningOuvrier= [];
        foreach($etabs as $etab){
            $ligne = DB::table('plannings')
            ->select('etablissement_id','nom_etablissement','jour','start','end','type_poubelle','adresse')
            ->join('etablissements','plannings.etablissement_id','=','etablissements.id')
            ->where('etablissement_id',$etab->id)
            ->orderBy('jour', 'asc')
            ->get();
            array_push($planningOuvrier,$ligne);
        }
        return $planningOuvrier;
    }
}
