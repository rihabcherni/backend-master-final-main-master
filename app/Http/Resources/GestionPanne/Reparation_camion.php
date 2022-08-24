<?php

namespace App\Http\Resources\GestionPanne;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Mecanicien;
use App\Models\Camion;

class Reparation_camion extends JsonResource{
    public function toArray($request)
    {
        $matricule= Camion::find($this->camion_id)->matricule;
        $mecanicien_nom_prenom= Mecanicien::find($this->mecanicien_id)->nom.' '.Mecanicien::find($this->mecanicien_id)->prenom;
        $mecanicien_cin= Mecanicien::find($this->mecanicien_id)->CIN;
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
        return [
            'id' => $this->id,
            'camion_id' => $this->camion_id,
            'matricule' => $matricule,
            'mecanicien_id' => $this->mecanicien_id,
            'mecanicien_CIN' => $mecanicien_cin,
            'mecanicien_nom_prenom' => $mecanicien_nom_prenom,
            'image_panne_camion'=> $this->image_panne_camion,
            'description_panne' => $this->description_panne,
            'cout'=> $this->cout,
            'date_debut_reparation'=> $this->date_debut_reparation,
            'date_fin_reparation'=> $this->date_fin_reparation,
            'camion'=> Camion::find($this->camion_id),
            'mecanicien'=> Mecanicien::find($this->mecanicien_id),
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $deleted_at,
        ];
    }
}
