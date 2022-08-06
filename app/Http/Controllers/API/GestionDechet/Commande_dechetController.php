<?php
namespace App\Http\Controllers\API\GestionDechet;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Commande_dechet as Commande_dechetResource;
use App\Models\Commande_dechet;
use App\Http\Requests\GestionDechet\Commande_dechetRequest;

class Commande_dechetController extends BaseController{
    public function index(){
        $commande = Commande_dechet::all();
        return $this->handleResponse(Commande_dechetResource::collection($commande), 'tous les commandes de dechets!');
    }
    public static function store(Commande_dechetRequest $request){
        $input = $request->all();
        $commande = Commande_dechet::create($input);
        return $this->handleResponse(new Commande_dechetResource($commande), 'commande crée!');
    }
    public function show($id){
        $commande = Commande_dechet::find($id);
        if (is_null($commande)) {
            return $this->handleError('commande dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new Commande_dechetResource($commande), 'commande existante.');
        }
    }
    public function update(Commande_dechetRequest $request, Commande_dechet $commande){
        $input = $request->all();
        $commande->update($input);
        return $this->handleResponse(new Commande_dechetResource($commande), 'commande modifié!');
    }
    public function destroy($id) {
        $commande =Commande_dechet::find($id);
        if (is_null($commande)) {
            return $this->handleError('commande dechet n\'existe pas!');
        }
        else{
            $commande->delete();
            return $this->handleResponse(new Commande_dechetResource($commande), 'commande dechet supprimé!');
        }
    }

    public function afficherDechetsClient(){

        
        $commande = Commande_dechet::where('client_dechet_id', '=',auth()->guard('client_dechet')->user()->id)->get();
        // return $commande;
        if (is_null($commande)) {
            return $this->handleError('commande dechet n\'existe pas!');
        }
        else{
            return $this->handleResponse(Commande_dechetResource::collection($commande), 'tous les commandes de dechets!');
        }
    }
}
