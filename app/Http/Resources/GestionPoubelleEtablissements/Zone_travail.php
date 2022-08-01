<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use Illuminate\Http\Resources\Json\JsonResource;

class Zone_travail extends JsonResource{
    public function toArray($request){
       return [
        'id' => $this->id,
        'region' => $this->region,
        'quantite_total_collecte_plastique' => $this->quantite_total_collecte_plastique,
        'quantite_total_collecte_composte' => $this->quantite_total_collecte_composte,
        'quantite_total_collecte_papier' => $this->quantite_total_collecte_papier,
        'quantite_total_collecte_canette' => $this->quantite_total_collecte_canette,
        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
