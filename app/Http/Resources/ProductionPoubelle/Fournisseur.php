<?php

namespace App\Http\Resources\ProductionPoubelle;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Materiau_primaire;
class Fournisseur extends JsonResource{
    public function toArray($request){
        $liste=Materiau_primaire::where('fournisseur_id', $this->id)->get() ;
        $Liste_matieres=[];
        foreach($liste as $l){
            array_push($Liste_matieres,
            [
                'id'=>$l->id,
                "nom_materiel"=>$l->nom_materiel,
                "prix_unitaire"=>$l->prix_unitaire,
                "quantite"=>$l->quantite,
                "prix_total"=>$l->prix_total,
            ]);
        }

       return [
        'id' => $this->id,

        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'CIN' => $this->CIN,
        'photo' => $this->photo,
        'numero_telephone' => $this->numero_telephone,
        'email' => $this->email,
        'adresse'=> $this->adresse,
        'Liste_matieres'=>$Liste_matieres,
        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
        'deleted_at' => $this->deleted_at,

    ];
    }
}
