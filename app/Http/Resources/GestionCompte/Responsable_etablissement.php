<?php

namespace App\Http\Resources\GestionCompte;

use App\Models\Etablissement;
use Illuminate\Http\Resources\Json\JsonResource;

class Responsable_etablissement extends JsonResource{
    public function toArray($request){
        $etab_id = $this->etablissement_id;
        $etab= Etablissement::where('id',$etab_id)->first();
        $etab_nom="";
        $etab_nom= $etab->nom_etablissement;
        return [
            'id' => $this->id,
            'etablissement_id'=>$etab_id,
            'etablissement'=>$etab_nom,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'photo' => $this->photo,
            'numero_fixe' => $this->numero_fixe,
            'adresse' => $this->adresse,
            'numero_telephone' => $this->numero_telephone,
            'email' => $this->email,
            'mot_de_passe' => $this->mot_de_passe,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
