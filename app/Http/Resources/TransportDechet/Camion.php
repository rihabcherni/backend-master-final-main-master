<?php

namespace App\Http\Resources\TransportDechet;

use App\Models\Ouvrier;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Zone_travail;
use App\Models\Zone_depot;

class Camion extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,
            'zone_travail_id' => $this->zone_travail_id,
            'zone_travail' => Zone_travail::find($this->zone_travail_id),
            'ouvrier'=>Ouvrier::where('camion_id',$this->id)->get(),
            'zone_depot_id' => $this->zone_depot_id,
            'zone_depot' => Zone_depot::find($this->zone_depot_id),
            'matricule' => $this->matricule,
            'qrcode' => $this->qrcode,
            'heure_sortie' => $this->heure_sortie,
            'heure_entree' => $this->heure_entree,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'volume_maximale_camion' => $this->volume_maximale_camion,
            'volume_actuelle_plastique' => $this->volume_actuelle_plastique,
            'volume_actuelle_papier' => $this->volume_actuelle_papier,
            'volume_actuelle_composte' => $this->volume_actuelle_composte,
            'volume_actuelle_canette' => $this->volume_actuelle_canette,
            'volume_carburant_consomme' => $this->volume_carburant_consomme,
            'Kilometrage' => $this->Kilometrage,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at->translatedFormat('H:i:s j F Y'),
        ];
    }
}

