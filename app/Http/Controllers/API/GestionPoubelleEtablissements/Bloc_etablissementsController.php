<?php

namespace App\Http\Controllers\API\GestionPoubelleEtablissements;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_etablissements as Bloc_etablissementsResource;
use App\Models\Bloc_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\Bloc_etablissementsRequest;
class Bloc_etablissementsController extends BaseController
{
    public function index(){
        $bloc_etablissement = Bloc_etablissement::all();
        return $this->handleResponse(Bloc_etablissementsResource::collection($bloc_etablissement), 'Affichage des blocs etablissement!');
    }
    public function store(Bloc_etablissementsRequest $request){
        $input = $request->all();
        $bloc_etablissement = Bloc_etablissement::create($input);
        return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'Block etablissement crée!');
    }
    public function show($id){
        $bloc_etablissement = Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement existante.');
        }
    }
    public function update(Bloc_etablissementsRequest $request, Bloc_etablissement $bloc_etablissement){
        $input = $request->all();
        $bloc_etablissement->update($input);
        return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement modifié!');
    }
    public function destroy($id){
        $bloc_etablissement =Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }
        else{
            $bloc_etablissement->delete();
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement supprimé!');
        }
    }

}

