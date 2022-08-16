<?php

namespace App\Http\Resources\GestionDechet;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Client_dechet;
use App\Models\Dechet;

class Commande_dechet extends JsonResource{
    public function toArray($request){
        Carbon::setLocale('fr');
        $matricule_fiscale= Client_dechet::find($this->client_dechet_id)->matricule_fiscale;
        $entreprise= Client_dechet::find($this->client_dechet_id)->nom_entreprise;
        $type_dechet=Dechet::find($this->detail_commande_dechet->dechet_id)->type_dechet;
        return [
            'id' => $this->id,
            'type' => $type_dechet,
            "quantite"=>$this->detail_commande_dechet->quantite,
            'montant_total' => $this->montant_total,
            'date_commande' => Carbon::parse($this->date_commande)->translatedFormat('d M Y'),
            'date_livraison' => $this->date_livraison,
            'type_paiment' => $this->type_paiment,

            'matricule_fiscale'=>$matricule_fiscale,
            'entreprise'=>$entreprise,

            'client_dechet_id' => $this->client_dechet_id,
            'client_dechet' => Client_dechet::find($this->client_dechet_id),

            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}

