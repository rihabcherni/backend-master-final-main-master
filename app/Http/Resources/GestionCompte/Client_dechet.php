<?php

namespace App\Http\Resources\GestionCompte;
use Illuminate\Http\Resources\Json\JsonResource;

class Client_dechet extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,

            'nom_entreprise' => $this->nom_entreprise,
            'matricule_fiscale' => $this->matricule_fiscale,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'numero_fixe' => $this->numero_fixe,
            'adresse' => $this->adresse,
            'numero_telephone' => $this->numero_telephone,
            'email' => $this->email,
            'mot_de_passe' => $this->mot_de_passe,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at
        ];
    }
}
