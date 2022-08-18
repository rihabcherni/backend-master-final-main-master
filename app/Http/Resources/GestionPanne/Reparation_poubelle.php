<?php

namespace App\Http\Resources\GestionPanne;

use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reparateur_poubelle;
use App\Models\Poubelle;

class Reparation_poubelle extends JsonResource{
    public function toArray($request)
    {
        $nom_poubelle= Poubelle::find($this->poubelle_id)->nom;
        $type= Poubelle::find($this->poubelle_id)->type;
        $reparateur_nom_prenom= Reparateur_poubelle::find($this->reparateur_poubelle_id)->nom.' '.Reparateur_poubelle::find($this->reparateur_poubelle_id)->prenom;
        $reparateur_cin= Reparateur_poubelle::find($this->reparateur_poubelle_id)->CIN;
        $bloc_poubelle= Bloc_poubelle::where('id',Poubelle::find($this->poubelle_id)->bloc_poubelle_id)->first();
        $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
        $etage_nom= $etage->nom_etage_etablissement;
        $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
        $bloc_etabl_nom= $bloc_etabl->nom_bloc_etablissement;
        $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();

       return [
            'id' => $this->id,

            'reparateur_poubelle' => Reparateur_poubelle::find($this->reparateur_poubelle_id),
            'reparateur_poubelle_id' => $this->reparateur_poubelle_id,
            'reparateur_nom_prenom' => $reparateur_nom_prenom,
            'reparateur_cin' => $reparateur_cin,

            'poubelle' => Poubelle::find($this->poubelle_id),
            'poubelle_id' => $this->poubelle_id,
            'nom_poubelle'=>$nom_poubelle,
            'type'=>$type,
            'etablissement'=>$etablissement->nom_etablissement ,
            'bloc_etablissement'=> $bloc_etabl_nom,
            'etage'=> $etage_nom,
            'bloc_poubelle_id' => $bloc_poubelle->id,

            'reparateur_poubelle' => Reparateur_poubelle::find($this->reparateur_poubelle_id),
            'image_panne_poubelle'=> $this->image_panne_poubelle,
            'description_panne' => $this->description_panne,
            'cout' => $this->cout,
            'date_debut_reparation' => $this->date_debut_reparation,
            'date_fin_reparation' => $this->date_fin_reparation,

            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
       ];
    }
}
