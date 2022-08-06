<?php

namespace App\Http\Controllers\API\ResponsableEtablissement;
use App\Http\Controllers\Globale\Controller;
use App\Models\Dechet;
use App\Models\Etablissement;
class SituationFinanciereController extends Controller{
    public function SituationFinanciereResponsableJour(){
        $user=auth()->guard('responsable_etablissement')->user();
        if($user !== null){
            $etab_id=$user->etablissement_id;
            $etablissement= Etablissement::where('id',$etab_id)->get();
            $plastique=$etablissement[0]->quantite_dechets_plastique;
            $papier=$etablissement[0]->quantite_dechets_papier;
            $composte=$etablissement[0]->quantite_dechets_composte;
            $canette=$etablissement[0]->quantite_dechets_canette;
            $PrixDechetes= Dechet::get(['type_dechet','prix_unitaire']);
            foreach($PrixDechetes as $p){
                if($p->type_dechet === "plastique"){
                    $p->quantite_collecte_plastique= $plastique ;
                    $p->total_revenu= $p->prix_unitaire * $plastique ;
                    $p->revenu_responsable=round((($p->prix_unitaire * $plastique) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                    $p->revenu_gestionnaire= round((($p->prix_unitaire * $plastique) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                }
                if($p->type_dechet === "papier"){
                    $p->quantite_collecte_papier= $papier ;
                    $p->total_revenu= $p->prix_unitaire * $papier ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $papier) *config('global.pourcentage_revenu_responsable')) /100 * 1000)/1000 ;
                    $p->revenu_gestionnaire= round((($p->prix_unitaire * $papier) *(100-config('global.pourcentage_revenu_responsable')))/100 * 1000)/1000 ;
                }
                if($p->type_dechet === "composte"){
                    $p->quantite_collecte_composte= $composte ;
                    $p->total_revenu= $p->prix_unitaire * $composte ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $composte) *config('global.pourcentage_revenu_responsable'))/100 * 1000)/1000;
                    $p->revenu_gestionnaire= round((($p->prix_unitaire * $composte) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                }
                if($p->type_dechet === "canette"){
                    $p->quantite_collecte_canette= $canette ;
                    $p->total_revenu= $p->prix_unitaire * $canette ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $canette) *config('global.pourcentage_revenu_responsable')) /100 * 1000)/1000 ;
                    $p->revenu_gestionnaire=round( (($p->prix_unitaire * $canette) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                }
            }
            $PrixDechetes[4]=["pourcentage_responsable"=>config('global.pourcentage_revenu_responsable')];
            return $PrixDechetes;
        }else {
             return "pas d'établissement";
        }
    }
    public function SituationFinanciereResponsableMensuel(){
        $user=auth()->guard('responsable_etablissement')->user();
        if($user !== null){
            $etab_id=$user->etablissement_id;
            $etablissement= Etablissement::where('id',$etab_id)->get();
            $plastique=$etablissement[0]->quantite_plastique_mensuel;
            $papier=$etablissement[0]->quantite_papier_mensuel;
            $composte=$etablissement[0]->quantite_composte_mensuel;
            $canette=$etablissement[0]->quantite_canette_mensuel;
            $PrixDechetes= Dechet::get(['type_dechet','prix_unitaire']);
            foreach($PrixDechetes as $p){
                if($p->type_dechet === "plastique"){
                    $p->quantite_collecte_plastique= $plastique ;
                    $p->total_revenu= $p->prix_unitaire * $plastique ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $plastique) *config('global.pourcentage_revenu_responsable'))/100* 1000)/1000;
                    $p->revenu_gestionnaire= round((($p->prix_unitaire * $plastique) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000 ;
                }
                if($p->type_dechet === "papier"){
                    $p->quantite_collecte_papier= $papier ;
                    $p->total_revenu= $p->prix_unitaire * $papier ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $papier) *config('global.pourcentage_revenu_responsable'))/100* 1000)/1000 ;
                    $p->revenu_gestionnaire= round((($p->prix_unitaire * $papier) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000 ;
                }
                if($p->type_dechet === "composte"){
                    $p->quantite_collecte_composte= $composte ;
                    $p->total_revenu= $p->prix_unitaire * $composte ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $composte) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000 ;
                    $p->revenu_gestionnaire=round((($p->prix_unitaire * $composte) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000 ;
                }
                if($p->type_dechet === "canette"){
                    $p->quantite_collecte_canette= $canette ;
                    $p->total_revenu= $p->prix_unitaire * $canette ;
                    $p->revenu_responsable= round((($p->prix_unitaire * $canette) *config('global.pourcentage_revenu_responsable'))/100* 1000)/1000 ;
                    $p->revenu_gestionnaire=round((($p->prix_unitaire * $canette) *(100-config('global.pourcentage_revenu_responsable')))/100* 1000)/1000 ;
                }
            }
            $PrixDechetes[4]=["pourcentage_responsable"=>config('global.pourcentage_revenu_responsable')];
            return $PrixDechetes;
        }else {
            return "pas d'établissement";
        }
    }
    public function SituationFinanciereGestionnaireJour(){
        $plastique=Etablissement::sum("quantite_dechets_plastique");
        $papier=Etablissement::sum("quantite_dechets_papier");
        $composte=Etablissement::sum("quantite_dechets_composte");
        $canette=Etablissement::sum("quantite_dechets_canette");
        $PrixDechetes= Dechet::get(['type_dechet','prix_unitaire']);
        foreach($PrixDechetes as $p){
            if($p->type_dechet === "plastique"){
                $p->quantite_collecte_plastique= $plastique ;
                $p->total_revenu= $p->prix_unitaire * $plastique ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $plastique) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $plastique) *(100-config('global.pourcentage_revenu_responsable')))/100* 1000)/1000 ;
            }
            if($p->type_dechet === "papier"){
                $p->quantite_collecte_papier= $papier ;
                $p->total_revenu= $p->prix_unitaire * $papier ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $papier) *config('global.pourcentage_revenu_responsable'))/100* 1000)/1000 ;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $papier) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000 ;
            }
            if($p->type_dechet === "composte"){
                $p->quantite_collecte_composte= $composte ;
                $p->total_revenu= $p->prix_unitaire * $composte ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $composte) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $composte) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000;
            }
            if($p->type_dechet === "canette"){
                $p->quantite_collecte_canette= $canette ;
                $p->total_revenu= $p->prix_unitaire * $canette ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $canette) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000 ;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $canette) *(100-config('global.pourcentage_revenu_responsable')))/100* 1000)/1000 ;
            }
        }
            $PrixDechetes[4]=["pourcentage_responsable"=>config('global.pourcentage_revenu_responsable')];
            return $PrixDechetes;
    }
    public function SituationFinanciereGestionnaireMensuel(){
        $plastique=Etablissement::sum("quantite_plastique_mensuel");
        $papier=Etablissement::sum("quantite_papier_mensuel");
        $composte=Etablissement::sum("quantite_composte_mensuel");
        $canette=Etablissement::sum("quantite_canette_mensuel");
        $PrixDechetes= Dechet::get(['type_dechet','prix_unitaire']);
        foreach($PrixDechetes as $p){
            if($p->type_dechet === "plastique"){
                $p->quantite_collecte_plastique= $plastique ;
                $p->total_revenu= $p->prix_unitaire * $plastique ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $plastique) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $plastique) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000;
            }
            if($p->type_dechet === "papier"){
                $p->quantite_collecte_papier= $papier ;
                $p->total_revenu= $p->prix_unitaire * $papier ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $papier) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000 ;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $papier) *(100-config('global.pourcentage_revenu_responsable')))/100* 1000)/1000 ;
            }
            if($p->type_dechet === "composte"){
                $p->quantite_collecte_composte= $composte ;
                $p->total_revenu= $p->prix_unitaire * $composte ;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $composte) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000 ;
                $p->revenu_gestionnaire_total= round((($p->prix_unitaire * $composte) *(100-config('global.pourcentage_revenu_responsable')))/100* 1000)/1000 ;
            }
            if($p->type_dechet === "canette"){
                $p->quantite_collecte_canette= $canette ;
                $p->total_revenu= round($p->prix_unitaire * $canette * 1000)/1000;
                $p->revenu_responsable_total_etablissement= round((($p->prix_unitaire * $canette) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000 ;
                $p->revenu_gestionnaire_total=round((($p->prix_unitaire * $canette) *(100-config('global.pourcentage_revenu_responsable'))) /100* 1000)/1000 ;
            }
        }
            $PrixDechetes[4]=["pourcentage_responsable"=>config('global.pourcentage_revenu_responsable')];
            return $PrixDechetes;
    }
}
