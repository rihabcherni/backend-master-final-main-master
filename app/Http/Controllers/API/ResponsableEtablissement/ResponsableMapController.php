<?php
namespace App\Http\Controllers\API\ResponsableEtablissement;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Camion;
use App\Models\Etablissement;
use App\Models\Responsable_etablissement;
use App\Models\Zone_depot;

class ResponsableMapController extends BaseController{
    public function ResponsableMap(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $responsable=Responsable_etablissement::where('etablissement_id',$etab_id)->get();
        $eta=[];
        $SPlastique=0; $SPapier=0;  $SCanette=0; $SComposte=0;
        $Sum_pourcentage_plastique=0; $Sum_pourcentage_papier=0; $Sum_pourcentage_canette=0; $Sum_pourcentage_composte=0;
        $nbrPlastique=0; $nbrPapier=0; $nbrCanette=0; $nbrComposte=0;
        $nbrPlastiqueSUP75=0; $nbrPapierSUP75=0; $nbrCanetteSUP75=0; $nbrComposteSUP75=0;
        $etablissement=  Etablissement::find($etab_id)->withCount('bloc_etablissements')->withCount('etage_etablissements')
        ->withCount('bloc_poubelles')->withCount('poubelles')->get();
        $etab=$etablissement->first();
        $camion=  Camion::findOrFail($etab->camion_id );
        $id_zone=$camion->zone_depot_id;
        $zone_depot=  Zone_depot::findOrFail($id_zone);
        foreach($etablissement as $etb){
            $blocetabs= $etb->bloc_etablissements;
            foreach($blocetabs as $blocetab){
                $etageetabs= $blocetab->etage_etablissements;
                foreach($etageetabs as $etageetab){
                    $blocpoubelles= $etageetab->bloc_poubelles;
                    foreach($blocpoubelles as $blocpoubelle){
                        $poubelles= $blocpoubelle->poubelles;
                        foreach ($poubelles as $poubelle){
                        $sum= ($poubelle->Etat* config('global.capacite_poubelle'))/100;
                                    if($poubelle->type==='plastique'){
                                        $SPlastique+= $sum;
                                        $Sum_pourcentage_plastique += $poubelle->Etat;
                                        $nbrPlastique+=1;
                                        if($poubelle->Etat>=75){
                                            $nbrPlastiqueSUP75+=1;
                                        }
                                    }else if($poubelle->type==='papier'){
                                        $SPapier+=  $sum;
                                        $Sum_pourcentage_papier += $poubelle->Etat;
                                        $nbrPapier+=1;
                                        if($poubelle->Etat>=75){
                                            $nbrPapierSUP75+=1;
                                        }
                                    }else if($poubelle->type==='canette'){
                                        $SCanette+=  $sum;
                                        $Sum_pourcentage_canette += $poubelle->Etat;
                                        $nbrCanette+=1;
                                        if($poubelle->Etat>=75){
                                            $nbrCanetteSUP75+=1;
                                        }
                                    }else if($poubelle->type==='composte'){
                                        $SComposte+=  $sum;
                                        $Sum_pourcentage_composte += $poubelle->Etat;
                                        $nbrComposte+=1;
                                        if($poubelle->Etat>=75){
                                            $nbrComposteSUP75+=1;
                                        }
                                    }
                        }
                    }
                }
            }
            if($nbrPlastique!==0){
                $moyPlastique=$SPlastique/$nbrPlastique;
                $pourcentage_plastique=$Sum_pourcentage_plastique/$nbrPlastique;
                $plastique=collect(["nombre_poubelle_plastique"=>$nbrPlastique,"somme_total_plastique"=>$SPlastique, "moyenne_poubelle_plastique"=>$moyPlastique,"moyenne_pourcentage_plastique"=>$pourcentage_plastique, "nbr_poubelle_plastique_rempli_plus_75"=>$nbrPlastiqueSUP75]);
            }else{
                $plastique=collect(["nombre_poubelle_plastique"=>$nbrPlastique,"somme_total_plastique"=>$SPlastique, "moyenne_poubelle_plastique"=>0,"moyenne_pourcentage_plastique"=>0, "nbr_poubelle_plastique_rempli_plus_75"=>$nbrPlastiqueSUP75]);
            }
            if($nbrPapier!==0){
                $moyPapier=$SPapier/$nbrPapier;
                $pourcentage_papier=$Sum_pourcentage_papier/$nbrPapier;
                $papier=collect(["nombre_poubelle_papier"=>$nbrPapier,"somme_total_papier"=>$SPapier, "moyenne_poubelle_papier"=>$moyPapier,"moyenne_pourcentage_papier"=>$pourcentage_papier, "nbr_poubelle_papier_rempli_plus_75"=>$nbrPapierSUP75],);
                }else{
                    $papier=collect(["nombre_poubelle_papier"=>$nbrPapier,"somme_total_papier"=>$SPapier, "moyenne_poubelle_papier"=>0,"moyenne_pourcentage_papier"=>0, "nbr_poubelle_papier_rempli_plus_75"=>$nbrPapierSUP75],);
                }
                if($nbrCanette!==0){
                    $moyCanette=$SCanette/$nbrCanette;
                    $pourcentage_canette=$Sum_pourcentage_canette/$nbrCanette;
                    $canette=collect(["nombre_poubelle_canette"=>$nbrCanette,"somme_total_canette"=>$SCanette, "moyenne_poubelle_canette"=>$moyCanette,"moyenne_pourcentage_canette"=>$pourcentage_canette, "nbr_poubelle_canette_rempli_plus_75"=>$nbrCanetteSUP75],);
                }else{
                    $canette=collect(["nombre_poubelle_canette"=>$nbrCanette,"somme_total_canette"=>$SCanette, "moyenne_poubelle_canette"=>0,"moyenne_pourcentage_canette"=>0, "nbr_poubelle_canette_rempli_plus_75"=>$nbrCanetteSUP75],);
                }
                if($nbrComposte!==0){
                    $moyComposte=$SComposte/$nbrComposte;
                    $pourcentage_composte=$Sum_pourcentage_composte/$nbrComposte;
                    $composte=collect( ["nombre_poubelle_composte"=>$nbrComposte,"somme_total_composte"=>$SComposte, "moyenne_poubelle_composte"=>$moyComposte,"moyenne_pourcentage_composte"=>$pourcentage_composte, "nbr_poubelle_composte_rempli_plus_75"=>$nbrComposteSUP75]);
                }else{
                    $composte=collect( ["nombre_poubelle_composte"=>$nbrComposte,"somme_total_composte"=>$SComposte, "moyenne_poubelle_composte"=>0,"moyenne_pourcentage_composte"=>0, "nbr_poubelle_composte_rempli_plus_75"=>$nbrComposteSUP75]);
                    }
            array_push($eta,$etb, $plastique, $papier, $canette, $composte);

        }
        return ['responsable'=>$responsable, 'camion'=>$camion,'zone_depot'=>$zone_depot,'etablissement'=>$eta];
    }

}
