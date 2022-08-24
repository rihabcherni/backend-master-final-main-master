<?php

namespace App\Http\Resources\GestionDechet;

use Illuminate\Http\Resources\Json\JsonResource;

class Dechet extends JsonResource{
    public function toArray($request){
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
       return [
        'id' => $this->id,

        'type_dechet' => $this->type_dechet,
        'prix_unitaire' => $this->prix_unitaire,
        'pourcentage_remise'=>$this->pourcentage_remise,
        'photo'=>$this->photo,
        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
        'deleted_at' => $deleted_at,
    ];
    }
}
