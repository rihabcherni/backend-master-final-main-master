<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use App\Models\Bloc_etablissement;
use App\Models\Etablissement;
use Illuminate\Http\Resources\Json\JsonResource;

class Etage_etablissements extends JsonResource{
    public function toArray($request)
    {
        $bloc_etabl= Bloc_etablissement::where('id',$this->bloc_etablissement_id)->first();
        $bloc_etabl_nom= $bloc_etabl->nom_bloc_etablissement;
        $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first()->nom_etablissement;
        return [
            'id' => $this->id,
            'nom_etage_etablissement' => $this->nom_etage_etablissement,
            'bloc_etablissement'=>$bloc_etabl_nom,
            'etablissement'=>$etablissement,

            'bloc_etablissement_id' => $this->bloc_etablissement_id,
            'bloc_poubelles' => $this->bloc_poubelles,

            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
        ];
     }
}
