<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Poubelle;

class Planning extends JsonResource{
    public function toArray($request){
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
       return [
        'id' => $this->id,
        'etablissement_id'=> $this->etablissement_id,
        'aujourdhui' => $this->jour,
        'start' => $this->start,
        'end' => $this->end,
        'type_poubelle' => $this->type_poubelle,
        'poubelle' => Poubelle::find($this->id_poubelle),
        'validation'=>$this->validation,
        'statut'=>$this->statut,
        'date_collecte'=>$this->date_collecte,
        'annee' => $this->created_at->format('y'),
        'mois' => $this->created_at->format('m'),
        'jour' => $this->created_at->format('d'),
        'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
        'deleted_at' => $deleted_at,
    ];
    }
}
