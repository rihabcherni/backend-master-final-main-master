<?php

namespace App\Http\Resources\GestionDechet;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Client_dechet;
use App\Models\Dechet;

class Commande_dechet extends JsonResource{
    public function toArray($request){
        Carbon::setLocale('fr');
        $client= Client_dechet::where('id',$this->client_dechet_id)->first();
        $matricule="";
        $entreprise="";
        if($client !==Null){
            $matricule=$client->matricule_fiscale;
            $entreprise=$client->nom_entreprise;
        }
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
        return [
            'id' => $this->id,
            'quantite_plastique'=> $this->quantite_plastique,
            'quantite_papier'=> $this->quantite_papier,
            'quantite_composte'=> $this->quantite_composte,
            'quantite_canette'=> $this->quantite_canette,

            'prix_plastique'=> $this->prix_plastique,
            'prix_papier'=> $this->prix_papier,
            'prix_composte'=> $this->prix_composte,
            'prix_canette'=> $this->prix_canette,

            'montant_total' => $this->montant_total,
            'date_commande' => Carbon::parse($this->date_commande)->translatedFormat('d M Y'),
            'date_livraison' => $this->date_livraison,
            'type_paiment' => $this->type_paiment,

            'matricule_fiscale'=>$matricule,
            'entreprise'=>$entreprise,

            'client_dechet_id' => $this->client_dechet_id,
            'client_dechet' => Client_dechet::find($this->client_dechet_id),

            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $deleted_at,
        ];
    }
}

