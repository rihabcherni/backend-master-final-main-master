<?php

namespace App\Http\Resources\GestionDechet;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GestionDechet\Dechet as DechetResource;
use App\Models\Dechet;
use App\Models\Commande_dechet;
class Detail_commande_dechet extends JsonResource{
    public function toArray($request){
        $deleted_at=null;
        if($this->deleted_at  !== null){
            $deleted_at=  $this->deleted_at->translatedFormat('H:i:s j F Y');
        }
        $type=Dechet::find($this->dechet_id)->type_dechet;
        return [
            'id' => $this->id,
            'commande_dechet_id' => $this->commande_dechet_id,
            'commande_dechet' =>Commande_dechet::find($this->commande_dechet_id) ,
            'type'=>$type ,
            'dechet' => new DechetResource( Dechet::find($this->dechet_id)),
            'quantite' => $this->quantite,
            'created_at' => $this->created_at->translatedFormat('H:i:s j F Y'),
            'updated_at' => $this->updated_at->translatedFormat('H:i:s j F Y'),
            'deleted_at' => $deleted_at,
        ];
    }
}
