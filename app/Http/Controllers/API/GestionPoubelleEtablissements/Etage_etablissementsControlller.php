<?php

namespace App\Http\Controllers\API\GestionPoubelleEtablissements;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Etage_etablissements as Etage_etablissementsResource;
use App\Models\Etage_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\Etage_etablissementsRequest;

class Etage_etablissementsControlller extends BaseController
{
    public function index(){
        $etage_etablissement = Etage_etablissement::all();
        return $this->handleResponse(Etage_etablissementsResource::collection($etage_etablissement), 'Affichage des etages etablissement!');
    }
    public function store(Etage_etablissementsRequest $request){
        $input = $request->all();
        $etage_etablissement = Etage_etablissement::create($input);
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'Block etablissement crée!');
    }
    public function show($id){
        $etage_etablissement = Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement existante.');
        }
    }
    public function update(Etage_etablissementsRequest $request, Etage_etablissement $etage_etablissement){
        $input = $request->all();
        $etage_etablissement->update($input);
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement modifié!');
    }
    public function destroy($id){
        $etage_etablissement =Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }
        else{
            $etage_etablissement->delete();
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement supprimé!');
        }
    }

}


