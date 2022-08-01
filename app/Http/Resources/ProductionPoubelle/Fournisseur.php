<?php

namespace App\Http\Resources\ProductionPoubelle;

use Illuminate\Http\Resources\Json\JsonResource;

class Fournisseur extends JsonResource{
    public function toArray($request){
       return [
        'id' => $this->id,

        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'CIN' => $this->CIN,
        'photo' => $this->photo,
        'numero_telephone' => $this->numero_telephone,
        'email' => $this->email,
        'adresse'=> $this->adresse,

        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
                     'deleted_at' => $this->deleted_at,

    ];
    }
}
