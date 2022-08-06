<?php

namespace App\Http\Controllers\Globale;

use App\Http\Controllers\Globale\Controller;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Camion;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use App\Models\Poubelle;
use App\Models\Reparateur_poubelle;
use App\Models\Zone_travail;
use Illuminate\Http\Request;

class RechercheController extends Controller{
    public function etablissementResponsable(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        return Etablissement::where('id', $etab_id)->first();
    }
          /*                     recherche zone travail par nom region:               */
    public function rechercheZoneTravail($region){
        $existe= Zone_travail::where('region', 'like', $region)->first();
        $zone= Zone_travail::where('region', 'like',$region)->get();
        if (is_null($existe)) {
            return ["message"=>"zone de travail n'existe pas!"];
        }else{
            return $zone;
        }
    }
         /*                     liste des etablissements par zone travail:             */
    public function rechercheEtablissementIDZone($zone_travail_id){
        $existe= Etablissement::where('zone_travail_id',$zone_travail_id)->first();
        $etablissement= Etablissement::where('zone_travail_id',$zone_travail_id)->get();
        if (is_null($existe)) {
            return ["message"=>"etablissement n'existe pas!"];
        }else{
            return $etablissement;
        }
    }
    public function rechercheEtablissementNomZone($region){
        $zone= Zone_travail::where('region', 'like',$region)->first();
        if (is_null($zone)) {
            return ["message"=>"zone de travail n'existe pas!"];
        }else{
            return Etablissement::where('zone_travail_id', 'like',$zone->id)->get();
        }
    }
         /*                      recherche reparateur poubelle adresse :               */
    public function rechercheReparateurPoubelleAdresse($adresse) {
        $reparateur_poubelle= Reparateur_poubelle::where('adresse', 'like',$adresse)->first();
        if (is_null($reparateur_poubelle)) {
            return ["message"=>"zone de travail n'existe pas!"];
        }else{
            return $reparateur_poubelle;
        }
    }

    public function rechercheBlocPoubelleEtab($etablissement_id,$nom_bloc_etablissement,$nom_etage_etablissement,$bloc_poubelle){
        $etb= Etablissement::where("id",$etablissement_id)->first();

        if (is_null($etb)) {
            return ["message"=>"etablissement n'existe pas!"];
        }else{
            $blocEtb= Bloc_etablissement::where("etablissement_id",$etb->id)->where("nom_bloc_etablissement",$nom_bloc_etablissement)->first();

            if (is_null($blocEtb)) {
                return ["message"=>"bloc etablissement n'existe pas!"];
            }else{
                $etage= Etage_etablissement::where("bloc_etablissement_id",$blocEtb->id)->where("nom_etage_etablissement",$nom_etage_etablissement)->with('bloc_poubelles')->first();
                if (is_null($etage)) {
                    return ["message"=>"etage etablissement n'existe pas!"];
                }else{
                $blocPoubelle= Bloc_poubelle::where("etage_etablissement_id",$etage->id)->where("id",$bloc_poubelle)->with('poubelles')->first();
                if (is_null($blocPoubelle)) {
                    return ["message"=>"bloc poubelle n'existe pas!"];
                }else{
                   return [$blocPoubelle];
            //   return [$etb,$blocEtb,$etage];
                }
             }
            }

        }
    }


    public function rechercheBlocPoubelleId($bloc_poubelle_id){
        $poubelle=  Poubelle::where('bloc_poubelle_id', 'like', $bloc_poubelle_id)->first();
        if (is_null($poubelle)) {
            return ["message"=>"poubelles n'existent pas dans cette bloc poubelle!"];
        }else{
            return Poubelle::where('bloc_poubelle_id', 'like', $bloc_poubelle_id)->get();
        }
    }
    public function searchEType($type){
        return Poubelle::where('type', 'like', $type)->get();
    }

    public function searchMatricule($matricule){
        return Camion::where('matricule', 'like', $matricule)->get();
    }
}
