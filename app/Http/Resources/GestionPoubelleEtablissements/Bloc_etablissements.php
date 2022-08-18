<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use App\Models\Etablissement;
use Illuminate\Http\Resources\Json\JsonResource;

class Bloc_etablissements extends JsonResource{
    public function toArray($request) {
        $etab= Etablissement::where('id',$this->etablissement_id)->first();
        $etab_nom= $etab->nom_etablissement;
        $etab_nom= $etab->nom_etablissement;
        return [
            'id' => $this->id,
            'etablissement' => $etab_nom,
            'etablissement_id' => $this->etablissement_id,
            'nom_bloc_etablissement' => $this->nom_bloc_etablissement,
            'etage_etablissements' => $this->etage_etablissements,
            'nombre_etage' => count($this->etage_etablissements),
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
        ];
     }
}
