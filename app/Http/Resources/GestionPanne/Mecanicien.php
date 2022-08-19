<?php

namespace App\Http\Resources\GestionPanne;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Reparation_camion;
use App\Models\Camion;
class Mecanicien extends JsonResource{
    public function toArray($request)
    {
        $liste=Reparation_camion::where('mecanicien_id', $this->id)->get() ;
        $liste_panne_camion=[];
        foreach($liste as $l){
            array_push($liste_panne_camion,
            [
                'id'=>$l->id,
                'id_camion'=>$l->camion_id,
                'matricule'=>Camion::find($l->camion_id)->matricule,
                "image_panne_camion"=>$l->image_panne_camion,
                "description_panne"=>$l->description_panne,
                "cout"=>$l->cout,
                "date_debut_reparation" =>$l->date_debut_reparation,
                "date_fin_reparation"=>$l->date_fin_reparation,
            ]);
        }

      return [
        'id' => $this->id,
        'Liste_camions_repares' => $liste_panne_camion,
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
