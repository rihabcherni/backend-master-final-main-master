<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use App\Models\Bloc_etablissement;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use Illuminate\Http\Resources\Json\JsonResource;

class Bloc_poubelle extends JsonResource{
    public function toArray($request)
    {
        $etage= Etage_etablissement::where('id',$this->etage_etablissement_id)->first();
        $nom_etage= $etage->nom_etage_etablissement;
        $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
        $nom_bloc_etabl= $bloc_etabl->nom_bloc_etablissement;
        $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first()->nom_etablissement;
       return [
        'id' => $this->id,

        'etage_etablissement_id' => $this->etage_etablissement_id,

        'etage'=>$nom_etage,
        'bloc_etabl'=>$nom_bloc_etabl,
        'etablissement'=>$etablissement,

        'poubelle'=>$this->poubelles,

        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
