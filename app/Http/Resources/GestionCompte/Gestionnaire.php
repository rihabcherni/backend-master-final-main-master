<?php
namespace App\Http\Resources\GestionCompte;

use Illuminate\Http\Resources\Json\JsonResource;
class Gestionnaire extends JsonResource{
    public function toArray($request) {
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
      return [
        'id' => $this->id,
        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'CIN' => $this->CIN,
        'photo'=> $this->photo,
        'adresse' => $this->adresse,
        'numero_telephone' => $this->numero_telephone,
        'email' => $this->email,
        'mot_de_passe' => $this->mot_de_passe,
        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
        'deleted_at' => $deleted_at,
    ];

    }
}

