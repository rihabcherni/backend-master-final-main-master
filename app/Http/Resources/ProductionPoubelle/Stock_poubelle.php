<?php

namespace App\Http\Resources\ProductionPoubelle;

use Illuminate\Http\Resources\Json\JsonResource;

class Stock_poubelle extends JsonResource{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type_poubelle'=> $this->type_poubelle,
            'quantite_disponible'=> $this->quantite_disponible,
            'description'=>$this->description,
            'photo'=>$this->photo,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
