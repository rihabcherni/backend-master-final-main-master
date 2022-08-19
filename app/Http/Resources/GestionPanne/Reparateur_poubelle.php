<?php

namespace App\Http\Resources\GestionPanne;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reparation_poubelle;
use App\Models\Poubelle;
class Reparateur_poubelle extends JsonResource{
    public function toArray($request)
    {
        $liste=Reparation_poubelle::where('reparateur_poubelle_id', $this->id)->get() ;
        $liste_panne_pouelle=[];
        foreach($liste as $l){
            array_push($liste_panne_pouelle,
            [
                'id'=>$l->id,
                'id_poubelle'=>$l->poubelle_id,
                'nom_poubelle'=>Poubelle::find($l->poubelle_id)->nom,
                'type'=>Poubelle::find($l->poubelle_id)->type,
                "image_panne_poubelle"=>$l->image_panne_poubelle,
                "description_panne"=>$l->description_panne,
                "cout"=>$l->cout,
                "date_debut_reparation" =>$l->date_debut_reparation,
                "date_fin_reparation"=>$l->date_fin_reparation,
            ]);
        }
       return [
        'id' => $this->id,
        'Liste_poubelles_repares' => $liste_panne_pouelle,

        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'CIN' => $this->CIN,
        'photo' => $this->photo,
        'numero_telephone' => $this->numero_telephone,
        'email' => $this->email,
        'adresse'=> $this->adresse,
        'mot_de_passe' => $this->mot_de_passe,

        'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
        'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
