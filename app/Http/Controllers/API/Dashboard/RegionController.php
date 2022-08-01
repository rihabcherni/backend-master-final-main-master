<?php

namespace App\Http\Controllers\API\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Bloc_poubelle;
use App\Models\Camion;
use App\Models\Etablissement;
use App\Models\Ouvrier;
use App\Models\Responsable_etablissement;
use App\Models\Zone_travail;
class RegionController extends Controller{
    public function Region(){
        $Zone_travail= Zone_travail::with('etablissements')->get();
        $blocPoubelle= Bloc_poubelle::with('poubelles')->get();
        $myArray = [
            'Zone_travail'=>$Zone_travail,
            'bloc-poubelle'=>$blocPoubelle,
        ];
        return $myArray;
    }
    public function RegionMap(){
        $zone_travail= Zone_travail::with('etablissements')->get();

        $zoneTravail=[];
        foreach($zone_travail as $zone){
            $camions=$zone->camions;
            $etabs= $zone->etablissements;
            foreach($etabs as $etab){
                $blocetabs= $etab->bloc_etablissements;
                foreach($blocetabs as $blocetab){
                    $etageetabs= $blocetab->etage_etablissements;
                    foreach($etageetabs as $etageetab){
                        $blocpoubelles= $etageetab->bloc_poubelles;
                        foreach($blocpoubelles as $blocpoubelle){
                            $poubelles= $blocpoubelle->poubelles;
                         }
            }
        }
            }
        array_push($zoneTravail,$zone);
     }
        return $zoneTravail;
    }
    public function GoogleMapId($id){
        $etabs=  Etablissement::findOrFail($id);
        $etabs= Etablissement::with('bloc_etablissements')->where('id','=',$id)->withCount(["bloc_etablissements"])->get();

        $eta=[];
        $etage=[];
        $nombreEtageTotal=0;
        $nombrePoubelleEtageTotal=0;

        $SPlastique=0; $SPapier=0;  $SCanette=0; $SComposte=0;

        $Sum_pourcentage_plastique=0; $Sum_pourcentage_papier=0; $Sum_pourcentage_canette=0; $Sum_pourcentage_composte=0;

        $nbrPlastique=0; $nbrPapier=0; $nbrCanette=0; $nbrComposte=0;

        $nbrPlastiqueSUP75=0; $nbrPapierSUP75=0; $nbrCanetteSUP75=0; $nbrComposteSUP75=0;

        foreach($etabs as $etb){
                $nbrBlocEtb= $etb->bloc_etablissements->count();
                $etab_id= $etb->id;
                $responsable_etablissement=  Responsable_etablissement::where('etablissement_id',$etab_id)->get();
                $blocetabs= $etb->bloc_etablissements;
                foreach($blocetabs as $blocetab){
                    $nombreEtageTotal+= $blocetab->etage_etablissements->count();
                    $etageetabs= $blocetab->etage_etablissements;
                    foreach($etageetabs as $etageetab){
                        $blocpoubelles= $etageetab->bloc_poubelles;
                        foreach($blocpoubelles as $blocpoubelle){
                            $poubelles= $blocpoubelle->poubelles;
                            $nombrePoubelleEtageTotal+=$blocpoubelle->poubelles->count();

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

                array_push($etage,[
                    "bloc_etablissement"=>$blocetab->nom_bloc_etablissement,
                    "etage_etablissement"=>$etageetab->nom_etage_etablissement,
                    "nbr_poubelle_etage_etablissement"=>$nombrePoubelleEtageTotal,
                ]);
         array_push($eta,$etb);
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
                array_push($eta,
                $plastique,
                $papier,
                $canette,
                $composte,
                ["responsable_etablissement"=>$responsable_etablissement],
                ["nombre bloc etablissement"=>$nbrBlocEtb,
                "nombre etage etablissement"=>$nombreEtageTotal,
                $etage
            ]
            );

            return $eta ;
    }
    public function GoogleMap(){
        $etabs= Etablissement::with('bloc_etablissements')->get();
        $eta=[];
        foreach($etabs as $etb){
                $blocetabs= $etb->bloc_etablissements;
                foreach($blocetabs as $blocetab){
                    $etageetabs= $blocetab->etage_etablissements;
                    foreach($etageetabs as $etageetab){
                        $blocpoubelles= $etageetab->bloc_poubelles;
                        foreach($blocpoubelles as $blocpoubelle){
                            $poubelles= $blocpoubelle->poubelles;

                         }
        }
            }
        array_push($eta,$etb);
     }
        return $eta;
    }
    public function GoogleMapCamion(){
        $camion_ouvrier=[];
        $camions=  Camion::all();
        foreach($camions as $camion){
          $ouvriers=  Ouvrier::where('camion_id', $camion->id)->get();
               if( !($ouvriers->isEmpty())){
                    $zone= Zone_travail::where('id',$camion->zone_travail_id)->get();
                    $camionOuvrier = array_merge(['camion'=>array_merge(['region'=>$zone->toArray()],$camion->toArray())],['ouvrier'=>$ouvriers]);
                    array_push($camion_ouvrier,$camionOuvrier);
                }
        }
        return $camion_ouvrier;
    }
    public function GoogleMapCamionId($id){
        $camion=  Camion::findOrFail($id);
        $camion= Camion::where('id','=',$id)->first();
        $zone= Zone_travail::where('id',$camion->zone_travail_id)->get();
        $camion_ouvrier=[];
        $ouvrier=  Ouvrier::where('camion_id', $camion->id)->get();
        $camionOuvrier = array_merge(['camion'=>array_merge(['region'=>$zone->toArray()],$camion->toArray())],['ouvrier'=>$ouvrier]);
        array_push($camion_ouvrier,$camionOuvrier);
        return $camion_ouvrier;
    }
    public function OuvrierCamion(){
        $ouvrier_camion=auth()->guard('ouvrier')->user();
        $id_camion=$ouvrier_camion->camion_id;
        $camion=  Camion::findOrFail($id_camion);
        $camion= Camion::where('id','=',$id_camion)->first();
        return [$ouvrier_camion,$camion];
    }
}
