<?php

namespace App\Http\Controllers\ClientDechet;
use App\Http\Controllers\Globale\Controller;
use App\Models\Commande_dechet;
use App\Http\Resources\GestionDechet\Commande_dechet as Commande_dechetResource;

class ClientDechetController extends Controller
{
    public function ClientCommande(){
        $client=auth()->guard('client_dechet')->user();
        $commande= Commande_dechet::where('client_dechet_id','=',$client->id)->get();
        return Commande_dechetResource::collection($commande);
    }

}
