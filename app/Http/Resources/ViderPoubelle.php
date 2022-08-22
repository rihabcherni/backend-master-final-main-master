<?php

namespace App\Http\Resources;

use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Camion;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use App\Models\Poubelle;
use Illuminate\Http\Resources\Json\JsonResource;

class ViderPoubelle extends JsonResource{
    public function toArray($request){
        $poubelle=Poubelle::find($this->poubelle_id);
        $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id)->first();
        $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
        $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
        $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
        $quantite=0;
        if($poubelle->type==="plastique"){
            $quantite=$this->quantite_depose_plastique;
        }else if($poubelle->type==="papier"){
            $quantite=$this->quantite_depose_papier;
        }else if($poubelle->type==="composte"){
            $quantite=$this->quantite_depose_composte;
        }else if($poubelle->type==="canette"){
            $quantite=$this->quantite_depose_canette;
        }
        $this->quantite=$quantite;
        $this->etablissement=$etablissement->nom_etablissement;
        return [
            'id' => $this->id,

            'poubelle_id' => $this->poubelle_id,
            'poubelle_nom' => $poubelle->nom,
            'type_poubelle' => $poubelle->type,
            'etat_lors_vidage' => $this->etat,

            "bloc_poubelle_id" =>$bloc_poubelle->id,
            "etage"=>$etage->nom_etage_etablissement,
            "bloc_etablissement"=>$bloc_etabl->nom_bloc_etablissement,
            "etablissement"=>$etablissement->nom_etablissement,

            'camion_id' => $this->camion_id,
            'camion_matricule' =>Camion::find($this->camion_id)->matricule ,

            'date_depot' => $this->date_depot,
            'quantite_depose' => $quantite,


            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,

        ];
    }
}
