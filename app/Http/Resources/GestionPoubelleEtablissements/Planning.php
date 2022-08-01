<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Poubelle;

class Planning extends JsonResource{
    public function toArray($request){

       return [
        'id' => $this->id,
        'aujourdhui' => $this->jour,
        'start' => $this->start,
        'end' => $this->end,
        'type_poubelle' => $this->type_poubelle,
        'id_poubelle' => $this->id_poubelle,
        'poubelle' => Poubelle::find($this->id_poubelle),
        'validation'=>$this->validation,
        'annee' => $this->created_at->format('y'),
        'mois' => $this->created_at->format('m'),
        'jour' => $this->created_at->format('d'),
        'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
