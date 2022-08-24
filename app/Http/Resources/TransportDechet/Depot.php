<?php

namespace App\Http\Resources\TransportDechet;

use App\Models\Camion;
use App\Models\Ouvrier;
use App\Models\Zone_depot;
use App\Models\Zone_travail;
use Illuminate\Http\Resources\Json\JsonResource;

class Depot extends JsonResource{
    public function toArray($request){
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
       return [
        'id' => $this->id,
        'zone_depot_id' => $this->zone_depot_id,
        'camion_id' => $this->camion_id,
        'zone_depot' => Zone_depot::find($this->zone_depot_id),
        'camion' => Camion::find($this->camion_id),
        'ouvrier' => Ouvrier::where('camion_id',$this->camion_id)->get(),
        'zone_travail' =>Zone_travail::find(Zone_depot::find($this->zone_depot_id)->zone_travail_id),
        'date_depot' => $this->date_depot,
        'quantite_depose_plastique' => $this->quantite_depose_plastique,
        'quantite_depose_papier' => $this->quantite_depose_papier,
        'quantite_depose_composte' => $this->quantite_depose_composte,
        'quantite_depose_canette' => $this->quantite_depose_canette,

        'created_at' => $this->created_at->format('d/m/y H:i:s'),
        'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
        'deleted_at' => $deleted_at,
    ];
    }
}
