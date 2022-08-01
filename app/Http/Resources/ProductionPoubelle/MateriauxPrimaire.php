<?php

namespace App\Http\Resources\ProductionPoubelle;

use App\Models\Fournisseur;
use Illuminate\Http\Resources\Json\JsonResource;

class MateriauxPrimaire extends JsonResource{
    public function toArray($request) {
        $nom= Fournisseur::find($this->fournisseur_id)->nom.' '.Fournisseur::find($this->fournisseur_id)->prenom;
        $cin= Fournisseur::find($this->fournisseur_id)->CIN;
        return [
            'id' => $this->id,
            'fournisseur_id' => $this->fournisseur_id,
            'cin' => $cin,
            'fournisseur_nom' => $nom,
            'nom_materiel' => $this->nom_materiel,
            'prix_unitaire' => $this->prix_unitaire,
            'quantite' => $this->quantite,
            'prix_total' => $this->prix_total,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
