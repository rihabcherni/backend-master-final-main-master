<?php
namespace App\Http\Controllers\API\ProductionPoubelle;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\Fournisseur as FournisseurResource;
use App\Models\Fournisseur;
use App\Http\Requests\ProductionPoubelle\FournisseurRequest;

class FournisseurController extends BaseController{
    public function index(){
        $fournisseur = Fournisseur::all();
        return $this->handleResponse(FournisseurResource::collection($fournisseur), 'Affichage des fournisseurs');
    }
    public function store(FournisseurRequest $request){
        $input = $request->all();
        $fournisseur = Fournisseur::create($input);
        return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur crée!');
    }
    public function show($id){
        $fournisseur = Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur existe.');
        }
    }
    public function update(FournisseurRequest $request, Fournisseur $fournisseur){
        $input = $request->all();
        $fournisseur->update($input);
        return $this->handleResponse(new FournisseurResource($fournisseur), ' fournisseur modifié!');
    }
    public function destroy($id){
        $fournisseur =Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }
        else{
            $fournisseur->delete();
            return $this->handleResponse(new FournisseurResource($fournisseur),'fournisseur supprimé!');
        }
    }
}
