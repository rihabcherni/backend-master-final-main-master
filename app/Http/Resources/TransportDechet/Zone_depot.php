<?php
namespace App\Http\Resources\TransportDechet;

use App\Models\Zone_travail;
use Illuminate\Http\Resources\Json\JsonResource;

class Zone_depot extends JsonResource{
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'zone_travail_id'=> $this->zone_travail_id,
        'zone_travail'=>Zone_travail::find($this->zone_travail_id) ,
        'adresse' => $this->adresse,
        'longitude' => $this->longitude,
        'latitude' => $this->latitude,
        'quantite_depot_maximale' => $this->quantite_depot_maximale,
        'quantite_depot_actuelle_plastique' => $this->quantite_depot_actuelle_plastique,
        'quantite_depot_actuelle_papier' => $this->quantite_depot_actuelle_papier,
        'quantite_depot_actuelle_composte' => $this->quantite_depot_actuelle_composte,
        'quantite_depot_actuelle_canette' => $this->quantite_depot_actuelle_canette,

        'created_at' => $this->created_at->format('d/m/y H:i:s'),
        'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
