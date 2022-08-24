<?php

namespace App\Http\Resources\ProductionPoubelle;

use App\Models\Fournisseur;
use Illuminate\Http\Resources\Json\JsonResource;

class MateriauxPrimaire extends JsonResource{
    public function toArray($request) {
        $nom= Fournisseur::find($this->fournisseur_id)->nom.' '.Fournisseur::find($this->fournisseur_id)->prenom;
        $cin= Fournisseur::find($this->fournisseur_id)->CIN;
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
        return [
            'id' => $this->id,
            'fournisseur_id' => $this->fournisseur_id,
            'fournisseur' =>Fournisseur::find($this->fournisseur_id),
            'fournisseur_nom' => $nom,
            'cin' => $cin,
            'fournisseur_numero_telephone'=>Fournisseur::find($this->fournisseur_id)->numero_telephone,
            'nom_materiel' => $this->nom_materiel,
            'prix_unitaire' => $this->prix_unitaire,
            'quantite' => $this->quantite,
            'prix_total' => $this->prix_total,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $deleted_at,
        ];
    }
}
