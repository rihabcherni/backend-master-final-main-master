<?php

namespace App\Http\Controllers\ResponsableEtablissement\DashboardResponsableEtablissement;
use App\Http\Controllers\Globale\Controller;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\GestionPoubelleEtablissements\Poubelle as PoubelleResource;

class GlobaleStatistiqueController extends Controller{
    public function globaleStatistiques(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::where('id',$etab_id)->withcount('bloc_etablissements')->
            withcount('etage_etablissements')-> withcount('bloc_poubelles')->  withcount('poubelles')->

            withMax('poubelles', 'etat')->withMin('poubelles', 'etat')-> withAvg('poubelles', 'etat')->

            withCount(['poubelles','poubelles as poubelle_plastique' => function (Builder $query) { $query->where('type', 'plastique'); },])->
            withCount(['poubelles','poubelles as poubelle_papier' => function (Builder $query) { $query->where('type', 'papier'); },])->
            withCount(['poubelles','poubelles as poubelle_composte' => function (Builder $query) { $query->where('type', 'composte'); },])->
            withCount(['poubelles','poubelles as poubelle_canette' => function (Builder $query) { $query->where('type', 'canette'); },])->
            with('poubelles')->get();

            $p= $etablissement[0]->poubelles;
            $all=[];
            $arplastique=[];$arpapier=[];$arcomposte=[];$arcanette=[];
            $p=PoubelleResource::collection($p);
            foreach($p as $poub){
                if($poub->type==='plastique'){
                array_push($arplastique,$poub);
                }
                if($poub->type==='papier'){
                    array_push($arpapier,$poub);
                }
                if($poub->type==='composte'){
                    array_push($arcomposte,$poub);
                }
                if($poub->type==='canette'){
                    array_push($arcanette,$poub);
                }
            }
            array_push($all , ['plastique'=>$arplastique,'papier'=>$arpapier, 'composte'=>$arcomposte, 'canette'=> $arcanette]);
            $sum_plastique=0;
            $sum_papier=0;
            $sum_composte=0;
            $sum_canette=0;
            foreach( $etablissement[0]->poubelles as $poubelle){
                if($poubelle->type==='plastique'){
                    $sum_plastique+= ($poubelle->Etat * config('global.capacite_poubelle'))/100;
                }else if($poubelle->type==='papier'){
                    $sum_papier+= ($poubelle->Etat * config('global.capacite_poubelle'))/100;
                }else if($poubelle->type==='composte'){
                    $sum_composte+= ($poubelle->Etat * config('global.capacite_poubelle'))/100;
                }else if($poubelle->type==='canette'){
                    $sum_canette+= ($poubelle->Etat * config('global.capacite_poubelle'))/100;
                }
            }
            /*****************************************         plastique    ************************************************************** */
                $min_poubelle_plastique =$etablissement[0]->poubelles->where("type","plastique")->min("Etat");
                $max_poubelle_plastique =$etablissement[0]->poubelles->where("type","plastique")->max("Etat");
                $pourcentage_poubelle_plastique =$etablissement[0]->poubelles->where("type","plastique")->avg("Etat");
            /*****************************************         papier    ************************************************************** */
                $min_poubelle_papier =$etablissement[0]->poubelles->where("type","papier")->min("Etat");
                $max_poubelle_papier =$etablissement[0]->poubelles->where("type","papier")->max("Etat");
                $pourcentage_poubelle_papier =$etablissement[0]->poubelles->where("type","papier")->avg("Etat");
            /*****************************************         composte    ************************************************************** */
                $min_poubelle_composte =$etablissement[0]->poubelles->where("type","composte")->min("Etat");
                $max_poubelle_composte =$etablissement[0]->poubelles->where("type","composte")->max("Etat");
                $pourcentage_poubelle_composte =$etablissement[0]->poubelles->where("type","composte")->avg("Etat");
            /*****************************************         canette    ************************************************************** */
                $min_poubelle_canette =$etablissement[0]->poubelles->where("type","canette")->min("Etat");
                $max_poubelle_canette =$etablissement[0]->poubelles->where("type","canette")->max("Etat");
                $pourcentage_poubelle_canette =$etablissement[0]->poubelles->where("type","canette")->avg("Etat");

        $somme_dechets=$sum_plastique+$sum_papier+$sum_composte+$sum_canette;
        $etablissement->push([
                    'somme_qt_dechet_plastique'=>round($sum_plastique * 1000)/1000,
                    'min_qt_poubelle_plastique'=>$min_poubelle_plastique,
                    'max_qt_poubelle_plastique'=>$max_poubelle_plastique,
                    'pourcentage_qt_poubelle_plastique'=>round($pourcentage_poubelle_plastique* 1000)/1000,

                'somme_qt_dechet_papier'=>round($sum_papier * 1000)/1000,
                'min_qt_poubelle_papier'=>$min_poubelle_papier,
                'max_qt_poubelle_papier'=>$max_poubelle_papier,
                'pourcentage_qt_poubelle_papier'=>round($pourcentage_poubelle_papier* 1000)/1000,


                'somme_qt_dechet_composte'=>round($sum_composte * 1000)/1000,
                'min_qt_poubelle_composte'=>$min_poubelle_composte,
                'max_qt_poubelle_composte'=>$max_poubelle_composte,
                'pourcentage_qt_poubelle_composte'=>round($pourcentage_poubelle_composte* 1000)/1000,


                'somme_qt_dechet_canette'=>round($sum_canette * 1000)/1000,
                'min_qt_poubelle_canette'=>$min_poubelle_canette,
                'max_qt_poubelle_canette'=>$max_poubelle_canette,
                'pourcentage_qt_poubelle_canette'=>round($pourcentage_poubelle_canette* 1000)/1000,

            'somme'=>[
                "plastique"=>round($sum_plastique * 1000)/1000,
                "papier"=>round($sum_papier * 1000)/1000,
                "composte"=>round($sum_composte * 1000)/1000,
                "canette"=>round($sum_canette * 1000)/1000,
            ],
            'somme_qt_dechet'=>$somme_dechets,

            'pourcentage_plastique'=>round((($sum_plastique/$somme_dechets)*100)* 100)/100,
            'pourcentage_papier'=>round((($sum_papier/$somme_dechets)*100)* 100)/100,
            'pourcentage_composte'=>round((($sum_composte/$somme_dechets)*100)* 100)/100,
            'pourcentage_canette'=>round((($sum_canette/$somme_dechets)*100)* 100)/100,

        ]);
        $etablissement->push(['poubelle_triee'=>$all]);

        return  $etablissement;
    }
}

