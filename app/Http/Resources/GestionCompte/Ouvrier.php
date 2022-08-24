<?php

namespace App\Http\Resources\GestionCompte;

use App\Models\Camion;
use Illuminate\Http\Resources\Json\JsonResource;

class Ouvrier extends JsonResource{
    public function toArray($request){
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
        $matricule= Camion::find($this->camion_id)->matricule;
        return [
            'id' => $this->id,
            'camion_id'=> $this->camion_id,
            'matricule'=> $matricule,
            'poste'=> $this->poste,
            'qrcode'=> $this->qrcode,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'CIN' => $this->CIN,
            'photo' => $this->photo,
            'numero_telephone' => $this->numero_telephone,
            'email' => $this->email,
            'mot_de_passe' => $this->mot_de_passe,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $deleted_at,
        ];
    }
}
