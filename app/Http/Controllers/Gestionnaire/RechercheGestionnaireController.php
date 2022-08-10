<?php

namespace App\Http\Controllers\Gestionnaire;
use App\Http\Controllers\Globale\Controller;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;

class RechercheGestionnaireController extends Controller{
    public function BlocEtablissementListe($etab){
        $etab_id= Etablissement::where("nom_etablissement", $etab)->first()->id;
        $bloc_etab= Bloc_etablissement::where('etablissement_id', $etab_id)->pluck("nom_bloc_etablissement");
        return $bloc_etab;
    }

    public function EtageEtablissementListe($etab, $bloc_etab){
        $etab_id= Etablissement::where("nom_etablissement", $etab)->first()->id;
        $id_bloc_etablissement= Bloc_etablissement::where("etablissement_id",$etab_id)->where('nom_bloc_etablissement', $bloc_etab)->pluck("id");
        $etage= Etage_etablissement::where("bloc_etablissement_id", $id_bloc_etablissement)->pluck("nom_etage_etablissement");
        return $etage;
    }

    public function  BlocPoubelleListe($etab, $bloc_etab, $etage){
        $etab_id= Etablissement::where("nom_etablissement", $etab)->first()->id;
        $id_bloc_etablissement= Bloc_etablissement::where("etablissement_id",$etab_id)->where('nom_bloc_etablissement', $bloc_etab)->pluck("id");
        $id_etage= Etage_etablissement::where("bloc_etablissement_id",$id_bloc_etablissement)->where('nom_etage_etablissement', $etage)->pluck("id");
        $bloc_poubelle= Bloc_poubelle::where("etage_etablissement_id", $id_etage)->pluck("id");
        return $bloc_poubelle;
    }
}
